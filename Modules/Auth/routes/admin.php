<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\admin\AuthController;


Route::controller(AuthController::class)->middleware('admin-guest')->group(function () {
    Route::view('/login', 'auth::admin.login')->name('login');
    Route::post('/login', 'requestOtp');
    Route::get('/otp', 'getOtpPage')->name('otp');
    Route::post('/otp', 'validateOtp');
});

Route::post('/logout', 'AuthController@logout')->name('logout');
