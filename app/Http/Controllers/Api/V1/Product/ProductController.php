<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
{
    public function index(): JsonResponse
    {
        $products = Product::all();

        return $this->showAll($products, 200);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->showOne($product, 200);
    }
}
