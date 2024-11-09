<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ProductBuyerTransactionsController extends ApiController
{
    public function index(Product $product, Buyer $buyer): JsonResponse
    {
        // Get transactions for this product and buyer
        $transactions = $product->transactions()->where(
            'buyer_id', $buyer->id
        )->get();

        return $this->showAll($transactions, 200);
    }

    public function store(Request $request, Product $product, Buyer $buyer): JsonResponse
    {
        $rules = [
            'quantity' => ['required', 'integer', 'min:1'],
        ];

        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->infoResponse('The buyer must be different from the seller', Response::HTTP_CONFLICT);
        }

        if (!$product->isAvailable()) {
            return $this->infoResponse('The product is not available', Response::HTTP_CONFLICT);
        }

        if ($product->quantity < $request->quantity) {
            return $this->infoResponse('The product does not have enough units for this transaction', Response::HTTP_CONFLICT);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'total_price' => $product->price * $request->quantity,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
