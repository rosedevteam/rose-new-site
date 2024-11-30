<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('log', 'logIndex')->name('log.index');
});
