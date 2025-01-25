<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'index')->name('index');

// static pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/ham-masir', 'ham-masir')->name('ham-masir');
//


Route::post('logout', [\Modules\Auth\Http\Controllers\AuthController::class, 'logout'])->name('logout');
