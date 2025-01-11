<?php

use Modules\Wallet\Http\Controllers\admin\WalletController;
use Modules\Wallet\Http\Controllers\admin\WalletTransactionController;


Route::resource('wallettransactions', WalletTransactionController::class);

Route::resource('wallets', WalletController::class);
