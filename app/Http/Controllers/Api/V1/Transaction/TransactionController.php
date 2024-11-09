<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class TransactionController extends ApiController
{
    public function index(): JsonResponse
    {
        $transactions = Transaction::all();

        return $this->showAll($transactions, 200);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return $this->showOne($transaction, 200);
    }
}
