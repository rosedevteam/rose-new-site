<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'index')->name('index');

// static pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/هم-مسیر', 'ham-masir')->name('ham-masir');
//
