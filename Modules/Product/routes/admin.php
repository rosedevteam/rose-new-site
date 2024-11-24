<?php

use Modules\Product\Http\Controllers\admin\ProductController;


Route::controller(ProductController::class)->prefix('/product')->group(function () {
    Route::get('/', 'index')->name("index");
});
