<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth::index')->name('index')->middleware('admin');

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth::login')->name('login');
    Route::post('/login', 'login');
    Route::view('/reset-password', 'auth::reset-password')->name('reset-password');
    Route::post('/reset-password', 'resetPassword');
});
