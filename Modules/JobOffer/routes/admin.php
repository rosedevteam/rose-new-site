<?php

use Modules\JobOffer\Http\Controllers\admin\JobOfferController;

//Route::controller(JobOfferController::class)->prefix('/job-offer')->name('joboffer.')->group(function () {
//    Route::get('/', 'index')->name('index');
//    Route::get('/create', 'create')->name('create');
//    Route::post('/create', 'store')->name('store');
//    Route::get('{jobOffer}', 'show')->name('show');
//    Route::patch('{jobOffer}/edit', 'update')->name('update');
//    Route::delete('{jobOffer}', 'destroy')->name('destroy');
//});

Route::resource('job-offers', JobOfferController::class);
