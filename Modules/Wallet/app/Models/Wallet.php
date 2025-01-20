<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

// use Modules\Wallet\Database\Factories\WalletFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded;
    protected $hidden = ['pivot'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function calculateBalance()
    {
        $transactions = $this->transactions()->get();
        $credit = $transactions->where('type', 'credit')->sum('amount');
        $debit = $transactions->where('type', 'debit')->sum('amount');
        $this->balance = $credit - $debit;
        $this->save();
    }
}
