<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\admin\AuthController;
use Modules\Auth\Http\Controllers\admin\TokenController;


Route::controller(AuthController::class)->middleware('admin-login')->group(function () {
    Route::get('/login' , [AuthController::class , 'index'])->name('login');
    Route::post("/login", [AuthController::class, 'login']);
//token
    Route::get("/token", [TokenController::class, 'show'])->name('login.token');
    Route::post("/token", [TokenController::class, 'token'])->name('login.token.send');

});

Route::post('/logout', 'AuthController@logout')->middleware('admin')->name('logout');
