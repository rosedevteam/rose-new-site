<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\admin\UserController;


Route::controller(UserController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
});
