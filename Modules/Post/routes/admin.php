<?php


use Modules\Post\Http\Controllers\admin\PostController;


Route::controller(PostController::class)->prefix('post')->group(function () {
    Route::get('/', 'index')->name("index");
    Route::get('/create', 'create')->name("create");
    Route::post('/create', 'store')->name("store");
    Route::get('/{post:url}', 'show')->name("show");
    Route::patch('/{post:url}', 'update')->name("update");
    Route::get('/{post:url}/edit', 'edit')->name("edit");
});
