<?php

use Modules\User\Http\Controllers\front\UserController;

Route::post('/users/birthday', [UserController::class, 'setBirthday'])->name('users.birthday');
