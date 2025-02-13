<?php

use Modules\Subscription\Http\Controllers\admin\SubscriptionController;
use Modules\Subscription\Http\Controllers\admin\TelegramController;

//Route::resource('subscriptions', SubscriptionController::class);

Route::resource('telegramSubscriptions' , \Modules\Subscription\Http\Controllers\admin\TelegramSubscriptionController::class);

Route::resource('telegrams', TelegramController::class);
