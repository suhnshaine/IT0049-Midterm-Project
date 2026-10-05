<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProductModel();

        return view('products/index', [
            'products' => $model
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ]);
    }

    public function createForm()
    {
        helper('form');
        return view('products/form', [
            'title' => 'Add Product',
            'product' => null
        ]);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|numeric|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $image = $this->uploadImage();

        if ($image === false) {
            return redirect()->back()->withInput();
        }

        $model = new ProductModel();

        $model->insert([
            'name' => trim($this->request->getPost('name')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $image,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/products')
            ->with('message', 'Product added successfully.');
    }

    public function edit(int $id)
    {
        helper('form');
        $product = (new ProductModel())->find($id);

        if (! $product) {
            throw PageNotFoundException::forPageNotFound(
                'Product not found.'
            );
        }

        return view('products/form', [
            'title' => 'Edit Product',
            'product' => $product
        ]);
    }

    public function update(int $id)
    {
        $model = new ProductModel();

        if (! $model->find($id)) {
            throw PageNotFoundException::forPageNotFound(
                'Product not found.'
            );
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'price' => 'required|numeric|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => trim($this->request->getPost('name')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $image = $this->uploadImage();

        if ($image === false) {
            return redirect()->back()->withInput();
        }

        if ($image !== null) {
            $data['image'] = $image;
        }

        $model->update($id, $data);

        return redirect()
            ->to('/products')
            ->with('message', 'Product updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new ProductModel();
        $model->delete($id);

        return redirect()
            ->to('/products')
            ->with('message', 'Product deleted successfully.');
    }

    private function uploadImage(): string|false|null
    {
        $file = $this->request->getFile('image');

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $rules = [
            'image' =>
                'uploaded[image]' .
                '|is_image[image]' .
                '|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]' .
                '|max_size[image,2048]'
        ];

        if (! $this->validateData([], $rules)) {
            return false;
        }

        $newName = $file->getRandomName();
        $uploadPath = FCPATH . 'uploads';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $file->move($uploadPath, $newName);

        service('image')
            ->withFile($uploadPath . DIRECTORY_SEPARATOR . $newName)
            ->fit(500, 500, 'center')
            ->save($uploadPath . DIRECTORY_SEPARATOR . $newName);

        return $newName;
    }
}