<?php

namespace App\Traits;

use Modules\Cart\Classes\Helpers\Cart;

trait CartTools
{
    public static function addCartToDatabase($cart , $totalPrice)
    {
        $userCart = auth()->user()->cart()->create([
            'total' => $totalPrice,
            'is_notified' => 0
        ]);
        $userCart->products()->attach($cart->all()->pluck('product.id')->toArray());
    }

    public static function editCartToDatabase($cart , $totalPrice , $userCart)
    {
        auth()->user()->cart()->update([
            'total' => $totalPrice
        ]);
        $userCart->products()->sync($cart->all()->pluck('product.id')->toArray());
    }
}
