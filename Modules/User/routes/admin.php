<?php

use Modules\User\Http\Controllers\admin\RoleController;
use Modules\User\Http\Controllers\admin\UserController;


Route::resource('users', UserController::class);
Route::patch('users/{user}/role', [UserController::class, 'setRole'])->name('users.role');

Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index')->name('roles.index');
    Route::post('/', 'store')->name('roles.store');
    Route::patch('/{role}', 'update')->name('roles.update');
});
