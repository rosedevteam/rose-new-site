<?php

use Modules\Menu\Http\Controllers\admin\MenuController;

Route::resource('menus', MenuController::class);
Route::patch('sort', [MenuController::class, 'sort'])->name('menus.sort');
