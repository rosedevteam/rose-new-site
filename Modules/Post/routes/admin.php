<?php


use Modules\Post\Http\Controllers\admin\PostController;


Route::controller(PostController::class)->prefix('post')->group(function () {
    Route::get('/', 'index')->name("index");
});
