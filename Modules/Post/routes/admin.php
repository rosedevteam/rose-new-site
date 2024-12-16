<?php


use Modules\Post\Http\Controllers\admin\PostController;

\Illuminate\Support\Facades\Route::resource('posts', PostController::class);
