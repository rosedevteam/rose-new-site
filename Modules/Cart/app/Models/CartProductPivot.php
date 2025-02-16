<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Product\Models\Product;
use Modules\Subscription\Models\TelegramSubscription;

// use Modules\Cart\Database\Factories\CartProductPivotFactory;

class CartProductPivot extends Pivot
{
    use HasFactory;
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function telegramSubscription()
    {
        return $this->belongsTo(TelegramSubscription::class, 'telegram_subscription');
    }


}
