<?php

use Modules\Category\Http\Controllers\admin\CategoryController;

Route::resource('categories', CategoryController::class);
