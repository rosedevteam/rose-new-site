<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::get('/', [AdminController::class, "index"])->name('index');
