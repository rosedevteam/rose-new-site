<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Models\Product;

// use Modules\Subscription\Database\Factories\TelegramSubscriptionFactory;

class TelegramSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // protected static function newFactory(): TelegramSubscriptionFactory
    // {
    //     // return TelegramSubscriptionFactory::new();
    // }
}
