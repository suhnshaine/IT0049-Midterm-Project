<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    protected ProductModel $productModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('products/index', [
            'products' => $this->productModel
                ->orderBy('id', 'DESC')
                ->findAll(),
        ]);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal|greater_than[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
            'image' => [
                'rules' => [
                    'permit_empty',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[image,2048]',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = $this->uploadImage();

        $this->productModel->insert([
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image'          => $imageName,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/products')
            ->with('success', 'Product added successfully.');
    }

    public function edit(int $id)
    {
        $product = $this->findProduct($id);

        return view('products/edit', [
            'product' => $product,
        ]);
    }

    public function update(int $id)
    {
        $product = $this->findProduct($id);

        $rules = [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal|greater_than[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
            'image' => [
                'rules' => [
                    'permit_empty',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[image,2048]',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = $this->uploadImage();

        $data = [
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        if ($imageName !== null) {
            $data['image'] = $imageName;
            $this->deleteImageFile($product['image'] ?? null);
        }

        $this->productModel->update($id, $data);

        return redirect()
            ->to('/products')
            ->with('success', 'Product updated successfully.');
    }

    public function delete(int $id)
    {
        $product = $this->findProduct($id);

        $this->productModel->delete($id);
        $this->deleteImageFile($product['image'] ?? null);

        return redirect()
            ->to('/products')
            ->with('success', 'Product deleted successfully.');
    }

    private function findProduct(int $id): array
    {
        $product = $this->productModel->find($id);

        if (! $product) {
            throw PageNotFoundException::forPageNotFound(
                'Product not found.'
            );
        }

        return $product;
    }

    private function uploadImage(): ?string
    {
        $image = $this->request->getFile('image');

        if (
            ! $image ||
            ! $image->isValid() ||
            $image->hasMoved()
        ) {
            return null;
        }

        $uploadPath = FCPATH . 'uploads/products';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $image->getRandomName();
        $image->move($uploadPath, $newName);

        return $newName;
    }

    private function deleteImageFile(?string $imageName): void
    {
        if (! $imageName) {
            return;
        }

        $imagePath = FCPATH . 'uploads/products/' . $imageName;

        if (is_file($imagePath)) {
            unlink($imagePath);
        }
    }
}