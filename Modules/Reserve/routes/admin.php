<?php

use Modules\Reserve\Http\Controllers\admin\ReserveController;

Route::resource('reserves', ReserveController::class);

Route::post('reserves/notifyAvailable/{product}', [ReserveController::class, 'notifyAvailable'])->name('reserves.notifyAvailable');
