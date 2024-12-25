<?php

use Modules\DailyReport\Http\Controllers\admin\DailyReportController;

Route::resource('dailyreports', DailyReportController::class);

Route::get('/dailyreports/file/{dailyReport}', [DailyReportController::class, 'file'])->name('dailyreports.file');
