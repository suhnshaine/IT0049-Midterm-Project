<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use Throwable;

class SaleController extends BaseController
{
    protected SaleModel $saleModel;
    protected ProductModel $productModel;
    protected CustomerModel $customerModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->saleModel = new SaleModel();
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        return view('sales/index', [
            'sales' => $this->saleModel->getSalesHistory(),
        ]);
    }

    public function create()
    {
        return view('sales/create', [
            'products' => $this->productModel
                ->where('stock_quantity >', 0)
                ->orderBy('name', 'ASC')
                ->findAll(),

            'customers' => $this->customerModel
                ->orderBy('full_name', 'ASC')
                ->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'product_id' => 'required|integer|is_not_unique[products.id]',
            'customer_id' => 'permit_empty|integer|is_not_unique[customers.id]',
            'quantity' => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $productId = (int) $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');
        $customerId = $this->request->getPost('customer_id');

        if ($customerId === null || $customerId === '') {
            $customerId = null;
        } else {
            $customerId = (int) $customerId;
        }

        $database = db_connect();
        $database->transBegin();

        try {
            // Lock the selected product until the sale is completed.
            $product = $database
                ->query(
                    'SELECT * FROM products WHERE id = ? FOR UPDATE',
                    [$productId]
                )
                ->getRowArray();

            if (! $product) {
                $database->transRollback();

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'The selected product was not found.');
            }

            if ($quantity > (int) $product['stock_quantity']) {
                $database->transRollback();

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'The requested quantity exceeds the available stock.'
                    );
            }

            $totalPrice = (float) $product['price'] * $quantity;
            $remainingStock =
                (int) $product['stock_quantity'] - $quantity;

            $this->saleModel->insert([
                'product_id'  => $productId,
                'customer_id' => $customerId,
                'sold_by'     => (int) session()->get('user_id'),
                'quantity'    => $quantity,
                'total_price' => $totalPrice,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            $this->productModel->update($productId, [
                'stock_quantity' => $remainingStock,
            ]);

            if ($database->transStatus() === false) {
                $database->transRollback();

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'The sale could not be recorded. Please try again.'
                    );
            }

            $database->transCommit();
        } catch (Throwable $exception) {
            $database->transRollback();

            log_message('error', $exception->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'An unexpected error occurred while recording the sale.'
                );
        }

        return redirect()
            ->to('/sales')
            ->with('success', 'Sale recorded successfully.');
    }
}