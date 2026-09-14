<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProductModel();

        $data['products'] = $model
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('products/index', $data);
    }
}