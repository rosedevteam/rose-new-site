<?php

use Modules\User\Http\Controllers\front\UserController;

Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
