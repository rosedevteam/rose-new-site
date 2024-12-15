<?php

use Modules\User\Http\Controllers\admin\UserController;


//Route::controller(UserController::class)->prefix('/user')->group(function () {
//    Route::get('/', 'index')->name('index');
//    Route::post('/', 'store')->name('store');
//    Route::get('/{user}', 'show')->name('show');
//    Route::patch('/{user}/edit', 'update')->name('update');
//    Route::delete('/{user}', 'destroy')->name('destroy');
//});
//

Route::resource('users', UserController::class);
