<?php

use Modules\JobApplication\Http\Controllers\admin\JobApplicationController;

//Route::controller(JobApplicationController::class)->prefix('job-application')
//    ->name('jobapplication.')->group(function () {
//        Route::get('/', 'index')->name('index');
//        Route::get('{jobApplication}', 'show')->name('show');
//        Route::patch('{jobApplication}', 'update')->name('update');
//    });


Route::resource('jobapplications', JobApplicationController::class);
