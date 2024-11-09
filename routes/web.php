<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * The purpose of this regular expression is to exclude any routes starting with "api/v1/" from being matched by this route definition.
 * This is often used to separate API routes from other routes in a Laravel application.
 */

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '^(?!api\/v1\/)[\/\w\.-]*');
