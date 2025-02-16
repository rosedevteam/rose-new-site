<?php

namespace App\Traits;

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

    public static function editCartToDatabase($cart)
    {
        $userCart = auth()->user()->cart;
        $userCart->products()->syncWithoutDetaching($cart->all()->pluck('product.id')->toArray());
        $userCart->update([
            'total' => $userCart?->products->sum(function ($product) {
                if (!is_null($product->sale_price)) {
                    return ($product->sale_price);
                } else {
                    return  ($product->price);
                }
            })
        ]);
    }


}
