<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;

class SaleController extends BaseController
{
    public function index()
    {
        $saleModel = new SaleModel();

        return view('sales/index', [
            'sales' => $saleModel->getSalesHistory()
        ]);
    }

    public function createForm()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

        return view('sales/form', [
            'products' => $productModel
                ->where('stock_quantity >', 0)
                ->orderBy('name', 'ASC')
                ->findAll(),

            'customers' => $customerModel
                ->orderBy('full_name', 'ASC')
                ->findAll()
        ]);
    }

    public function create()
    {
        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'customer_id' => 'permit_empty|is_natural_no_zero',
            'quantity' => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $productModel = new ProductModel();

        $product = $productModel->find(
            (int) $this->request->getPost('product_id')
        );

        $quantity = (int) $this->request->getPost('quantity');

        if (! $product) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Selected product was not found.');
        }

        if ($quantity > (int) $product['stock_quantity']) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Insufficient stock. Available quantity: '
                    . $product['stock_quantity']
                );
        }

        $database = db_connect();
        $database->transStart();

        /*
         * Decrease stock only when enough stock remains.
         * This prevents selling more units than available.
         */
        $productModel
            ->where('id', $product['id'])
            ->where('stock_quantity >=', $quantity)
            ->set(
                'stock_quantity',
                'stock_quantity - ' . $quantity,
                false
            )
            ->update();

        if ($database->affectedRows() !== 1) {
            $database->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The stock changed before the sale was completed.'
                );
        }

        $saleModel = new SaleModel();

        $saleModel->insert([
            'product_id' => $product['id'],
            'customer_id' => $this->request->getPost('customer_id') ?: null,
            'sold_by' => session()->get('user_id'),
            'quantity' => $quantity,
            'total_price' => $quantity * (float) $product['price'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $database->transComplete();

        if ($database->transStatus() === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'The sale could not be saved.');
        }

        return redirect()
            ->to('/sales')
            ->with('message', 'Sale recorded successfully.');
    }
}