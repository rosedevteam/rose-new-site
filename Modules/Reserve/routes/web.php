<?php

use Modules\Reserve\Http\Controllers\front\ReserveController;

Route::post('/reserve/{product}', [ReserveController::class, 'store']);
