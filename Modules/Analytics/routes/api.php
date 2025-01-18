<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\client\ApiClient;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::controller(ApiClient::class)->group(function () {
    Route::get('/companies', 'companies');
    Route::get('/indices', 'indices');
    Route::get('/trades/{id}', 'trades');
    Route::get('/legalTrades/{id}', 'legalTrades');
    Route::get('/indexValues/{id}', 'indexValues');
    Route::get('/bidAsk/{id}', 'bidAsk');
});
