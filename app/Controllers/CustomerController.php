<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class CustomerController extends BaseController
{
    protected CustomerModel $customerModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        return view('customers/index', [
            'customers' => $this->customerModel
                ->orderBy('id', 'DESC')
                ->findAll(),
        ]);
    }

    public function create()
    {
        return view('customers/create');
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]|is_unique[customers.email]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->insert([
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'email'      => trim((string) $this->request->getPost('email')),
            'phone'      => trim((string) $this->request->getPost('phone')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/customers')
            ->with('success', 'Customer added successfully.');
    }

    public function edit(int $id)
    {
        return view('customers/edit', [
            'customer' => $this->findCustomer($id),
        ]);
    }

    public function update(int $id)
    {
        $this->findCustomer($id);

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => "required|valid_email|max_length[100]|is_unique[customers.email,id,{$id}]",
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->update($id, [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')),
        ]);

        return redirect()
            ->to('/customers')
            ->with('success', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $this->findCustomer($id);

        try {
            $this->customerModel->delete($id);
        } catch (Throwable $exception) {
            return redirect()
                ->to('/customers')
                ->with(
                    'error',
                    'This customer cannot be deleted because they have an existing sale.'
                );
        }

        return redirect()
            ->to('/customers')
            ->with('success', 'Customer deleted successfully.');
    }

    private function findCustomer(int $id): array
    {
        $customer = $this->customerModel->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        return $customer;
    }
}