<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\admin\AuthController;


Route::controller(AuthController::class)->prefix('/login')->group(function () {
    Route::view('/', 'auth::admin.login')->name('login');
    Route::post('/', 'requestOtp');
    Route::get('/otp', 'getOtpPage')->name('otp');
    Route::post('/otp', 'validateOtp');
});
