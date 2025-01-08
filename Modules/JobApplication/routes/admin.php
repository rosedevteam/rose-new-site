<?php

use Modules\JobApplication\Http\Controllers\admin\JobApplicationController;

Route::resource('jobapplications', JobApplicationController::class);
Route::get('jobapplications/resume/{jobApplication}', [JobApplicationController::class, 'getResume'])->name('jobapplications.resume');
