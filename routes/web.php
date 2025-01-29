<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;


Route::view('/', 'index')->name('index');

// static pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/ham-masir', 'ham-masir')->name('ham-masir');
//


Route::post('logout', [AuthController::class, 'logout'])->name('logout');
