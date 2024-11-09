<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\User\UserController;

use App\Http\Controllers\Api\V1\Buyer\BuyerController;

use App\Http\Controllers\Api\V1\Seller\SellerController;

/**
 * Product
 */
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Product\ProductBuyersController;
use App\Http\Controllers\Api\V1\Product\ProductBuyerTransactionsController;

/**
 * Category
 */
use App\Http\Controllers\Api\V1\Category\CategoryController;

/**
 * Transaction
 */
use App\Http\Controllers\Api\V1\Transaction\TransactionController;
use App\Http\Controllers\Api\V1\Transaction\TransactionSellerController;
use App\Http\Controllers\Api\V1\Transaction\TransactionCategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/**
 * Users
 */
Route::PUT('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::resource('users', UserController::class)->except(['create', 'edit']);

/**
 * Category
 */
Route::resource('categories', CategoryController::class)->except(['create', 'edit']);

/**
 * Product
 */
Route::get('products/{product}/buyers/{buyer}/transactions', [ProductBuyerTransactionsController::class, 'index'])
    ->name('product-buyer-transactions.index');

Route::post('products/{product}/buyers/{buyer}/transactions', [ProductBuyerTransactionsController::class, 'store'])
    ->name('product-buyer-transactions.store');

Route::get('products/{product}/buyers', [ProductBuyersController::class, 'index'])
    ->name('product-transactions-buyers.index');

Route::resource('products', ProductController::class)->only(['index', 'show']);

/**
 * Buyers
 */
Route::resource('buyers', BuyerController::class)->only(['index', 'show']);

/**
 * Sellers
 */
Route::resource('sellers', SellerController::class)->only(['index', 'show']);

/**
 * Transaction
 */
Route::get('transactions/{transaction}/categories', [TransactionCategoriesController::class, 'index'])
    ->name('transaction-product-categories.index');

Route::get('transactions/{transaction}/seller', [TransactionSellerController::class, 'index'])
    ->name('transaction-product-seller.index');

Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
