<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'adminfront::index')->name('index')->middleware('admin');

Route::middleware(['guest'])->prefix('/login')->group(function () {
    Route::view('/', 'adminfront::login')->name('login');
    Route::post('/', 'login');
    Route::post('/otp', 'getOtp');
});
