<?php

use Modules\User\Http\Controllers\admin\UserController;


Route::resource('users', UserController::class);
Route::patch('users/{user}/role', [UserController::class, 'setRole'])->name('users.role');
