<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['guest', 'web'])->prefix('/login')->group(function () {
    Route::view('/', 'auth::admin.login')->name('login');
    Route::post('/', 'requestOtp');
    Route::get('/otp', 'getOtpPage')->name('otp');
    Route::post('/otp', 'validateOtp');
});
