<?php

use Modules\Order\Http\Controllers\admin\OrderController;

//Route::controller(OrderController::class)->prefix('/order')->group(function () {
//    Route::get('/', 'index')->name('index');
//    Route::get('{order}', 'show')->name('show');
//    Route::patch('{order}', 'update')->name('update');
//    Route::delete('{order}', 'destroy')->name('destroy');
//    Route::get('create', 'create')->name('create');
//    Route::post('create', 'store')->name('store');
//});

Route::resource('orders', OrderController::class);
