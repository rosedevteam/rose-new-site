<?php

use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\DiscountController;

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

Route::prefix('discount')->group(function() {
    Route::post('check', [\Modules\Discount\Http\Controllers\front\DiscountController::class , 'check'])->name('cart.discount.check');
    Route::post('delete' , [\Modules\Discount\Http\Controllers\front\DiscountController::class , 'destroy']);
});
