<?php


Route::group(['prefix' => 'pagebuilder'], function () {
    Route::get('/', [\Modules\PageBuilder\Http\Controllers\PageBuilderController::class, 'index'])->name('pagebuilder.show');
    Route::post('/upload', [\Modules\PageBuilder\Http\Controllers\PageBuilderController::class, 'uploader'])->name('pagebuilder.upload');
    Route::post('/store' , [\Modules\PageBuilder\Http\Controllers\PageBuilderController::class, 'store'])->name('pagebuilder.store');
});
