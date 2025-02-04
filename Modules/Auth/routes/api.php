<?php

use Modules\Auth\Http\Controllers\api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('up', 'up');
    Route::get('auth', 'auth');
    Route::post('send', 'send');
    Route::post('token', 'token');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
