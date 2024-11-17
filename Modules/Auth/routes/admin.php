<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::view('/', 'auth::index')->name('index')->middleware(Admin::class);

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth::login')->name('login');
    Route::post('/login', 'login');
});
