<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class ProductBuyersController extends ApiController
{
    public function index(Product $product): JsonResponse
    {
        $buyers = $product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id')
            ->values();

        return $this->showAll($buyers, 200);
    }
}
