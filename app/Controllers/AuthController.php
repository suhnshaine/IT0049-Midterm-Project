<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        helper('form');
        
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/products');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);

        session()->set([
            'isLoggedIn' => true,
            'user_id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
        ]);

        return redirect()
            ->to('/products')
            ->with('message', 'Login successful.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with('message', 'You have been logged out.');
    }
}