<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;
use Modules\User\Models\User;

// use Modules\Wallet\Database\Factories\WalletTransactionFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $guarded;

    protected static function booted()
    {
        parent::booted();

        // todo: won't be called in mass updates or deletes
        self::updated(function ($transaction) {
            self::calculateBalance($transaction->wallet);
        });

        self::created(function ($transaction) {
            self::calculateBalance($transaction->wallet);
        });

        self::deleted(function ($transaction) {
            self::calculateBalance($transaction->wallet);
        });

    }

    private static function calculateBalance(Wallet $wallet)
    {
        $walletTransactions = WalletTransaction::where('wallet_id', $wallet->id)->get();
        $credit = $walletTransactions->where('type', 'credit')->sum('amount');
        $debit = $walletTransactions->where('type', 'debit')->sum('amount');
        $wallet->balance = $credit - $debit;
        $wallet->save();
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
