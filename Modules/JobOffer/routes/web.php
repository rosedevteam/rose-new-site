<?php

use Illuminate\Support\Facades\Route;
use Modules\JobOffer\Http\Controllers\front\JobOfferController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/همکاری-با-ما')->name('joboffers.')->group(function () {
    Route::get('/', [JobOfferController::class, 'index'])->name('index');
    Route::get('/{jobOffer:title}', [JobOfferController::class, 'show'])->name('show');
});
