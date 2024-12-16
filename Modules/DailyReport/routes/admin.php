<?php

use Modules\DailyReport\Http\Controllers\admin\DailyReportController;


//Route::controller(DailyReportController::class)->prefix('/daily-report')->group(function () {
//    Route::get('/', 'index')->name('index');
//    Route::post('/', 'store')->name('store');
//    Route::patch('/{dailyReport}', 'update')->name('update');
//});

Route::resource('dailyreports', DailyReportController::class);
