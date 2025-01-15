<?php
Route::resources(['channels' => 'ChannelController']);
Route::get('channels/get/{channel}' , [\Modules\Channel\Http\Controllers\admin\ChannelController::class , 'get']);
Route::get('channel/get/users/{channel}' , [\Modules\Channel\Http\Controllers\admin\ChannelController::class  , 'getUsers']);
Route::delete('channel/delete/user/{channel}/{user}' , [\Modules\Channel\Http\Controllers\admin\ChannelController::class  , 'deleteUser']);


Route::post('channel/post/{channel}' , [\Modules\Channel\Http\Controllers\admin\MessageController::class , 'send']);
Route::patch('ticket/reply/edit/{message}' , [\Modules\Channel\Http\Controllers\admin\MessageController::class , 'updateMessage']);
Route::delete('channel/message/delete/{message}' , [\Modules\Channel\Http\Controllers\admin\MessageController::class , 'delete']);
