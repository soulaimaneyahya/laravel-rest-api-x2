<?php

namespace App\Http\Controllers\Api\V1\Buyer;

use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    public function index(): JsonResponse
    {
        $buyers = Buyer::all();

        return $this->showAll($buyers, 200);
    }

    public function show(Buyer $buyer): JsonResponse
    {
        return $this->showOne($buyer, 200);
    }
}
