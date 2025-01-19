<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\front\CartController;

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

Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/', 'cart')->name('cart.show');
    Route::post('/add/{product}', 'addToCart')->name('cart.add');
    Route::patch('/quantity/change', 'quantityChange')->name('cart.quantity.change');
    Route::delete('/delete/{cart}', 'deleteFromCart')->name('cart.destroy');
});
