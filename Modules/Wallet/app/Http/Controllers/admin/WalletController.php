<?php

namespace Modules\Wallet\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Wallet\Models\Wallet;

class WalletController extends Controller
{
    public function edit(Wallet $wallet)
    {
        Gate::authorize('view-wallet-transactions');
        $transactions = $wallet->transactions()->orderByDesc('created_at')->paginate(50);

        return view('wallet::admin.edit', compact('wallet', 'transactions'));
    }
}
