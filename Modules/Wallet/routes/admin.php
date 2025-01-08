<?php

use Modules\Wallet\Http\Controllers\admin\WalletTransactionController;


Route::resource('wallettransactions', WalletTransactionController::class);
