<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;
use Modules\User\Models\User;
use Modules\Wallet\Observers\WalletTransactionObserver;

#[ObservedBy(WalletTransactionObserver::class)]
class WalletTransaction extends Model
{
    use HasFactory;

    protected $guarded;
    protected $hidden = ['pivot'];

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
