<?php


use Modules\Comment\Http\Controllers\admin\CommentController;


Route::controller(CommentController::class)->prefix('/comment')->group(function () {
    Route::get('/', 'index')->name("index");
    Route::get('/{comment}', 'show')->name("show");
    Route::post('/{comment}', 'store')->name("store");
    Route::patch('/{comment}', 'update')->name("update");
});
