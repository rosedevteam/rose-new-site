<?php

use Modules\Product\Http\Controllers\admin\AttributeController;
use Modules\Product\Http\Controllers\admin\LessonController;
use Modules\Product\Http\Controllers\admin\ProductController;


Route::resource('products', ProductController::class);
//attributes
Route::delete('attributes/{attribute}' , [AttributeController::class , 'destroy'])->name('attributes.destroy');
Route::patch('attributes/' , [AttributeController::class , 'update'])->name('attributes.update');
//lessons
Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
Route::patch('lessons/', [LessonController::class, 'update'])->name('lessons.update');
