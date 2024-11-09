<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class TransactionCategoriesController extends ApiController
{
    public function index(Transaction $transaction): JsonResponse
    {
        $categories = $transaction->product->categories;

        return $this->showAll($categories, 200);
    }
}
