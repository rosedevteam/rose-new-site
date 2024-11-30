<?php

use Modules\User\Http\Controllers\admin\UserController;


Route::controller(UserController::class)->prefix('/user')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/deleted', 'deleted')->name('deleted');
    Route::get('/{user}', 'show')->name('show')->withTrashed();
    Route::put('/{user}/edit', 'update')->name('update');
    Route::delete('/{user}', 'destroy')->name('destroy');
    Route::patch('/{user}/restore', 'restore')->name('restore');
});
