<?php

use Modules\DailyReport\Http\Controllers\front\DailyReportController;


Route::get('/گزارشات-روزانه-بازار', [DailyReportController::class, 'index'])->name('index');
Route::get('dailyreports/{dailyReport}', [DailyReportController::class, 'show'])->name('show');
Route::get('dailyreports/{dailyReport}/download', [DailyReportController::class, 'download'])->name('download');
