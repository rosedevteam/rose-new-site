<?php

use Modules\Product\Http\Controllers\admin\AttributeController;
use Modules\Product\Http\Controllers\admin\ProductController;


//Route::controller(ProductController::class)->prefix('/product')->group(function () {
//    Route::get('/', 'index')->name("index");
//    Route::get('{product:slug}', 'show')->name("show");
//});

Route::resource('products', ProductController::class);
//attributes
Route::delete('attributes/{attribute}' , [AttributeController::class , 'destroy'])->name('attributes.destroy');
Route::patch('attributes/' , [AttributeController::class , 'update'])->name('attributes.update');
//lessons
Route::delete('lessons/{lesson}' , [\Modules\Product\Http\Controllers\Admin\LessonController::class , 'destroy'])->name('lessons.destroy');
Route::patch('lessons/' , [\Modules\Product\Http\Controllers\Admin\LessonController::class , 'update'])->name('lessons.update');
