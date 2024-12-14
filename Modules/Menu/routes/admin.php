<?php

use Modules\Menu\Http\Controllers\admin\MenuEntryController;

Route::controller(MenuEntryController::class)->prefix('/menu')->group(function () {
     Route::get('/', 'index')->name('index');
     Route::get('/create', 'create')->name('create');
     Route::post('/create', 'store')->name('store');
    Route::post('/sort', 'sort')->name('sort');
     Route::get('/{id}', 'show')->name('show');
     Route::patch('/{id}', 'update')->name('update');
});
