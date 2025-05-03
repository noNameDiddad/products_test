<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductResourceCollection;
use App\Services\CRUDServices\ProductCRUD\ProductCRUDService;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductCRUDService $productCRUDService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResourceCollection::make(
            $this->productCRUDService->indexWithPaginate(request()->all())
        );
    }
}
