<?php

use Modules\DailyReport\Http\Controllers\admin\DailyReportController;

Route::controller(DailyReportController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});
