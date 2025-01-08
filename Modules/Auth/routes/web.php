<?php

use Illuminate\Support\Facades\Route;

Route::prefix('login')->group(function () {
    Route::post("auth", [\Modules\Auth\Http\Controllers\front\LoginController::class, 'auth']);
    Route::post("token", [\Modules\Auth\Http\Controllers\front\LoginController::class, 'token']);
});

//Route::prefix('register')->group(function () {
//    Route::post("auth", [\Modules\Auth\Http\Controllers\front\RegisterController::class, 'auth']);
//    Route::post("token", [\Modules\Auth\Http\Controllers\front\RegisterController::class, 'token']);
//});


//Route::controller(\Modules\Auth\Http\Controllers\front\AuthController::class)->middleware('auth')->group(function () {
////token
//    Route::get("/token", [\Modules\Auth\Http\Controllers\front\TokenController::class, 'show'])->name('login.token');
//    Route::post("/token", [\Modules\Auth\Http\Controllers\front\TokenController::class, 'token'])->name('login.token.send');
//
//});
