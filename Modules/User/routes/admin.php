<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\admin\UserController;


Route::controller(UserController::class)->prefix('/user')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
});
