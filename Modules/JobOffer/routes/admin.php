<?php

use Modules\JobOffer\Http\Controllers\admin\JobApplicationController;
use Modules\JobOffer\Http\Controllers\admin\JobOfferController;

Route::controller(JobOfferController::class)->prefix('/job-offer')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
    Route::get('{jobOffer}', 'show')->name('show');
    Route::get('{jobOffer}/edit', 'edit')->name('edit');
    Route::patch('{jobOffer}/edit', 'update')->name('update');
    Route::delete('{jobOffer}', 'destroy')->name('destroy');
});

Route::controller(JobApplicationController::class)->prefix('job-application')
    ->name('jobapplication.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{jobApplication}', 'show')->name('show');
        Route::patch('{jobApplication}', 'update')->name('update');
    });
