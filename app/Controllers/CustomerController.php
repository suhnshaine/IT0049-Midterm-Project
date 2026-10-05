<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CustomerController extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();

        return view('customers/index', [
            'customers' => $model
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ]);
    }

    public function createForm()
    {
        return view('customers/form', [
            'title' => 'Add Customer',
            'customer' => null
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $model = new CustomerModel();

        $model->insert([
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')) ?: null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/customers')
            ->with('message', 'Customer added successfully.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        return view('customers/form', [
            'title' => 'Edit Customer',
            'customer' => $customer
        ]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();

        if (! $model->find($id)) {
            throw PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $model->update($id, [
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')) ?: null,
        ]);

        return redirect()
            ->to('/customers')
            ->with('message', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();
        $model->delete($id);

        return redirect()
            ->to('/customers')
            ->with('message', 'Customer deleted successfully.');
    }
}