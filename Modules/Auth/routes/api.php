<?php

use Modules\Auth\Http\Controllers\api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('up', 'up');
    Route::post('auth', 'auth');
    Route::post('token', 'token');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
