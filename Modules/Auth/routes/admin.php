<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth::admin.index')->name('index')->middleware('admin');

Route::middleware(['guest'])->prefix('/login')->group(function () {
    Route::view('/', 'auth::admin.login')->name('login');
    Route::post('/', 'login');
    Route::post('/otp', 'getOtp');
});
