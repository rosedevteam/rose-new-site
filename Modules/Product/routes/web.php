<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('products')->group(function () {
    Route::get('/', [\Modules\Product\Http\Controllers\front\ProductController::class, 'all'])->name('products.all');
    Route::get('/{product}', [\Modules\Product\Http\Controllers\front\ProductController::class, 'show'])->name('products.show');
});
