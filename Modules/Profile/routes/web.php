<?php

use Illuminate\Support\Facades\Route;

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/my-courses', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'myCourses'])->name('profile.courses');
    Route::get('/orders', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/referrals', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'referrals'])->name('profile.referrals');
    Route::post('/scores/exchange', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'exchangeScoreToWallet'])->name('profile.score.exchange');
    Route::get('settings', [\Modules\Profile\Http\Controllers\front\ProfileController::class, 'settings'])->name('profile.settings');
});

