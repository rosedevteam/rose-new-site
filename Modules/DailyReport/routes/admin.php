<?php

use Modules\DailyReport\Http\Controllers\admin\DailyReportController;


Route::controller(DailyReportController::class)->prefix('/daily-report')->group(function () {
    Route::get('/', 'index')->name('index');
});
