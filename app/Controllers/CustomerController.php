<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();

        $data['customers'] = $model
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('customers/index', $data);
    }
}