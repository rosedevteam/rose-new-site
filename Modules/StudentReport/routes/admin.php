<?php

use Modules\StudentReport\Http\Controllers\admin\StudentReportController;

Route::resource('studentreports', StudentReportController::class);

Route::get('studentreports/analysis/{studentReport}', [StudentReportController::class, 'analysis'])->name('studentreports.analysis');
