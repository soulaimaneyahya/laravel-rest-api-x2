<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Models\Seller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class SellerController extends ApiController
{
    public function index(): JsonResponse
    {
        $sellers = Seller::all();

        return $this->showAll($sellers, 200);
    }

    public function show(Seller $seller): JsonResponse
    {
        return $this->showOne($seller, 200);
    }
}
