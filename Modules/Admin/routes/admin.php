<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;


Route::controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('logs', 'LogController@index')->name('logs.index');
    Route::get('logs/{log}', 'LogController@show')->name('logs.show');
    Route::delete('logs', 'LogController@destroy')->name('logs.destroy');
});
