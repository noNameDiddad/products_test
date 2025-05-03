<?php

namespace App\Services\CRUDServices\ProductCRUD;

use App\Models\Product;
use App\Services\CRUDServices\BaseCRUDService;

class ProductCRUDService extends BaseCRUDService
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }
}