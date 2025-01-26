<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;

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

Route::prefix('payment')->middleware('auth')->group(function() {
    Route::post('/' , [\Modules\Payment\Http\Controllers\front\PaymentController::class , 'payment'])->name('payment.do');
    Route::get('/callback' , [\Modules\Payment\Http\Controllers\front\PaymentController::class , 'callback'])->name('payment.callback');
});
