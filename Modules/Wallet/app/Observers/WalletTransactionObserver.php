<?php

namespace Modules\Wallet\Observers;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Modules\Wallet\Models\WalletTransaction;

class WalletTransactionObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the WalletTransaction "created" event.
     */
    public function created(WalletTransaction $wallettransaction): void
    {
        $wallettransaction->wallet->calculateBalance();
    }

    /**
     * Handle the WalletTransaction "updated" event.
     */
    public function updated(WalletTransaction $wallettransaction): void
    {
        $wallettransaction->wallet->calculateBalance();
    }

    /**
     * Handle the WalletTransaction "deleted" event.
     */
    public function deleted(WalletTransaction $wallettransaction): void
    {
        $wallettransaction->wallet->calculateBalance();
    }

}
