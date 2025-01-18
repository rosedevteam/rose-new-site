<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\front\AnalyticsController;

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


Route::prefix('/analytics')->controller(AnalyticsController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/companies', 'companies');
    Route::get('/companies/{coId}', 'companies');
    Route::get('/indices', 'indices');
    Route::get('/indices/{indexId}', 'indices');
    Route::get('/trades/{coId}', 'trades');
    Route::get('/legalTrades/{coId}', 'legalTrades');
    Route::get('/indexValues/{indexId}', 'indexValues');
    Route::get('/bidAsk/{coId}', 'bidAsk');
});
