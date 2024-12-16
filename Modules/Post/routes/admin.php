<?php


use Modules\Post\Http\Controllers\admin\PostController;


//Route::controller(PostController::class)->prefix('post')->group(function () {
//    Route::get('/', 'index')->name("index");
//    Route::get('/create', 'create')->name("create");
//    Route::post('/create', 'store')->name("store");
//    Route::get('/{post:slug}', 'show')->name("show");
//    Route::patch('/{post:slug}', 'update')->name("update");
//    Route::get('/{post:slug}/edit', 'edit')->name("edit");
//});

Route::resource('posts', PostController::class);
