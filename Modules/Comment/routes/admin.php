<?php


use Modules\Comment\Http\Controllers\admin\CommentController;


Route::controller(CommentController::class)->prefix('/comment')->group(function () {
    Route::get('/', 'index')->name("index");
});
