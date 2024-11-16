<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.index')->name('login');
Route::post('/login', 'login');
