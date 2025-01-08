<?php

use Modules\DailyReport\Http\Controllers\front\DailyReportController;


Route::get('/گزارشات-روزانه-بازار', [DailyReportController::class, 'index'])->name('index');
Route::get('/گزارشات-روزانه-بازار/{dailyReport}', [DailyReportController::class, 'show'])->name('show');
