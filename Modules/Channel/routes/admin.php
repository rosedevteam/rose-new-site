<?php


use Modules\Channel\Http\Controllers\admin\ChannelController;
use Modules\Channel\Http\Controllers\admin\MessageController;

Route::resource('channels', ChannelController::class);
Route::get('channels/get/{channel}', [ChannelController::class, 'get']);
Route::get('channel/get/users/{channel}', [ChannelController::class, 'getUsers']);
Route::delete('channel/delete/user/{channel}/{user}', [ChannelController::class, 'deleteUser']);


Route::post('channel/post/{channel}', [MessageController::class, 'send']);
Route::patch('ticket/reply/edit/{message}', [MessageController::class, 'updateMessage']);
Route::delete('channel/message/delete/{message}', [MessageController::class, 'delete']);

