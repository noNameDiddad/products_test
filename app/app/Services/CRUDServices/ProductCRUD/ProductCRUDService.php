<?php

namespace App\Services\CRUDServices\ProductCRUD;

use App\Models\Product;
use App\Services\CRUDServices\BaseCRUDService;
use App\Services\CRUDServices\ProductCRUD\Filters\ProductPropertyFilter;
use App\Traits\PipelineFilterTrait;

class ProductCRUDService extends BaseCRUDService
{
    use PipelineFilterTrait;

    public function __construct()
    {
        parent::__construct(Product::class);
    }

    public function getFilters(): array
    {
        return [
            ProductPropertyFilter::class,
        ];
    }
}