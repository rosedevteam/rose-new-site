<?php


Route::get('/carts' , [\Modules\Cart\Http\Controllers\admin\CartController::class , 'index'])->name('carts.index');
