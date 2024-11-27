<?php

use Modules\Order\Http\Controllers\admin\OrderController;


Route::controller(OrderController::class)->prefix('/order')->group(function () {
    Route::get('/', 'index')->name('index');
});
