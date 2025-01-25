<?php

use Illuminate\Support\Facades\Route;

Route::prefix('login')->group(function () {
    Route::post("auth", [\Modules\Auth\Http\Controllers\front\LoginController::class, 'auth']);
    Route::post("token", [\Modules\Auth\Http\Controllers\front\LoginController::class, 'token']);
});

Route::prefix('register')->group(function () {
    Route::post("auth", [\Modules\Auth\Http\Controllers\front\RegisterController::class, 'auth']);
    Route::post("token", [\Modules\Auth\Http\Controllers\front\RegisterController::class, 'token']);
    Route::post("/", [\Modules\Auth\Http\Controllers\front\RegisterController::class, 'register']);
});


