<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;

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

Route::prefix('cart')->group(function () {
    Route::get('/' , [\Modules\Cart\Http\Controllers\front\CartController::class , 'cart'])->name('cart.show');
    Route::post('/add/{product}' , 'CartController@addToCart')->name('cart.add');
    Route::patch('/quantity/change' , 'CartController@quantityChange')->name('cart.quantity.change');
    Route::delete('/delete/{cart}' , 'CartController@deleteFromCart')->name('cart.destroy');
});
