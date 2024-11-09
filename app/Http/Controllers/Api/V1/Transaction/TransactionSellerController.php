<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class TransactionSellerController extends ApiController
{
    public function index(Transaction $transaction): JsonResponse
    {
        $seller = $transaction->product->seller;

        return $this->showOne($seller, 200);
    }
}
