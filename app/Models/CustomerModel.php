<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'full_name',
        'email',
        'phone',
        'address'
    ];

    protected $returnType = 'array';

    public function searchCustomer($keyword)
    {
        return $this->like('full_name', $keyword)
                    ->findAll();
    }
}
