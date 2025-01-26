<?php

use Modules\Auth\Http\Controllers\api\AuthController;

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::get('/up', 'up')->name('up');
    Route::post('/auth', 'auth')->name('auth');
    Route::post('/token/login', 'tokenLogin')->name('tokenLogin');
    Route::post('/token/register', 'tokenRegister')->name('tokenRegister');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/refresh', 'refresh')->name('refresh');
});
