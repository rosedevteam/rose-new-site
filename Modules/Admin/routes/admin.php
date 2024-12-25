<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('log', 'LogController@index')->name('logs.index');
    Route::get('log/{log}', 'LogController@show')->name('logs.show');
});


