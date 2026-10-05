<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image'
    ];

    protected $returnType = 'array';

    public function getLowStockProducts()
    {
        return $this->where('stock_quantity <=', 5)
                    ->findAll();
    }
}
