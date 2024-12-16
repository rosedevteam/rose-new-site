<?php


use Modules\Post\Http\Controllers\admin\PostController;

\Illuminate\Support\Facades\Route::resource('post', PostController::class);

<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 9566fdd9d5057222f7877f7b4f3ad3d6bbf5e18d
//Route::controller(PostController::class)->prefix('post')->group(function () {
//    Route::get('/', 'index')->name("index");
//    Route::get('/create', 'create')->name("create");
//    Route::post('/create', 'store')->name("store");
//    Route::get('/{post:slug}', 'show')->name("show");
//    Route::patch('/{post:slug}', 'update')->name("update");
//    Route::get('/{post:slug}/edit', 'edit')->name("edit");
//});

Route::resource('posts', PostController::class);
<<<<<<< HEAD
>>>>>>> 9566fdd9d5057222f7877f7b4f3ad3d6bbf5e18d
=======
>>>>>>> 9566fdd9d5057222f7877f7b4f3ad3d6bbf5e18d
