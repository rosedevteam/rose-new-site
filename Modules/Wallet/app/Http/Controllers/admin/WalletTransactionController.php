<?php

namespace Modules\Wallet\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Wallet\Models\WalletTransaction;

class WalletTransactionController extends Controller
{
    public function store()
    {
        Gate::authorize('create-wallet-transactions');
        $validData = request()->validate([
            'description' => 'nullable',
            'amount' => 'required',
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:credit,debit',
        ]);
        try {
            $transaction = auth()->user()->transactions()->create($validData);
            $after = $transaction->toArray();

            $this->log($transaction, compact('after'), 'ساخت تراکنش کیف پول');
            alert()->success('موفق', 'تراکنش با موفقیت ساخته شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(WalletTransaction $wallettransaction)
    {
        Gate::authorize('create-wallet-transactions');
        $validData = request()->validate([
            'description' => 'nullable',
            'amount' => 'required',
            'type' => 'required|in:credit,debit',
        ]);
        try {
            $before = $wallettransaction->toArray();
            $wallettransaction->update($validData);
            $after = $wallettransaction->toArray();

            $this->log($wallettransaction, compact('before', 'after'), 'ویرایش تراکنس کیف پول');
            alert()->success('موفق', 'تراکنش با موفقیت ویرایش داده شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    // todo destroy transactions
}
