<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\admin\AuthController;


Route::controller(AuthController::class)->middleware('admin-guest')->group(function () {
    Route::get('/login' , [AuthController::class , 'index'])->name('login');
    Route::post("/login", [AuthController::class, 'login']);
//token
    Route::get("/token", [\Modules\Auth\Http\Controllers\Admin\TokenController::class, 'show'])->name('login.token');
    Route::post("/token", [\Modules\Auth\Http\Controllers\Admin\TokenController::class, 'token'])->name('login.token.send');

});

Route::post('/logout', 'AuthController@logout')->name('logout');
