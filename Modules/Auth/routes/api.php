<?php

use Modules\Auth\Http\Controllers\api\AuthController;

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::get('/up', 'up')->name('up');
    Route::get('/login', 'login')->name('login');
});
