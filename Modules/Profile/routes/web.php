<?php

use Illuminate\Support\Facades\Route;
use Modules\Profile\Http\Controllers\ProfileController;

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/my-courses', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'myCourses'])->name('profile.courses');
    Route::get('/orders', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/referrals', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'referrals'])->name('profile.referrals');

});

