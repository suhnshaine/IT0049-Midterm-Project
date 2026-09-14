<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        $data['users'] = $model
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('users/index', $data);
    }
}