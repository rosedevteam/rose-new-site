<?php
Route::post("auth", [\Modules\Auth\Http\Controllers\front\AuthController::class, 'auth']);

//todo make a new middleware for user-guest
Route::controller(\Modules\Auth\Http\Controllers\front\AuthController::class)->middleware('auth')->group(function () {
//token
    Route::get("/token", [\Modules\Auth\Http\Controllers\front\TokenController::class, 'show'])->name('login.token');
    Route::post("/token", [\Modules\Auth\Http\Controllers\front\TokenController::class, 'token'])->name('login.token.send');

});
