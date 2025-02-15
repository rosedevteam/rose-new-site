<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Database\Factories\CartFactory;
use Modules\Discount\Models\Discount;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

// use Modules\Cart\Database\Factories\CartFactory;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(CartProductPivot::class)
            ->withPivot('auto_discount' , 'telegram_subscription');
    }

    public function getTotalAutoDiscounts()
    {
        return $this->products->sum(function ($product){
            return $product->getAutoDiscount();
        });
    }

    public function getTotalTelegramSubscriptions ()
    {
        return $this->products->sum(function ($product) {
            // Check if the pivot and telegram_subscription exist
            if ($product->pivot && $product->pivot->telegramSubscription) {
                return $product->pivot->telegramSubscription->price;
            }
            return 0; // Return 0 if no subscription is found
        });
    }


    public function getTotalProducts()
    {
        return $this->products->sum(function ($product){
            return $product->getPrice();
        });
    }

    public function hasDiscount()
    {
        return !!$this->discount_code;
    }

    public function getDiscountAmount()
    {
        if ($this->hasDiscount()) {
            return Discount::where('code' , $this->discount_code)->first()->amount;
        }
    }

    // Check if the cart has a Telegram subscription
    public function hasTelegramSubscription()
    {
        return $this->products->contains(function ($product) {
            return !is_null($product->pivot->telegram_subscription);
        });
    }

    public function getTelegramSubscription()
    {
        if ($this->hasTelegramSubscription()) {
            // Find the product with a Telegram subscription
            $productWithSubscription = $this->products->first(function ($product) {
                return !is_null($product->pivot->telegram_subscription);
            });

            // Return the Telegram subscription model
            return $productWithSubscription->pivot->telegramSubscription;
        }

        return null;
    }

    public function getCartTotalPayment()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Check if the user and their cart exist
        if (!$user || !$user->cart) {
            return 0; // Return 0 if the user or cart is not found
        }

        // Calculate the total payment
        $totalProducts = $this->getTotalProducts(); // Total price of products
        $totalTelegramSubscriptions = $this->getTotalTelegramSubscriptions(); // Total price of Telegram subscriptions
        $totalAutoDiscounts = $this->getTotalAutoDiscounts(); // Total auto discounts
        $totalDiscountCode = $this->getDiscountAmount();


        // Ensure all values are numeric
        $totalProducts = is_numeric($totalProducts) ? $totalProducts : 0;
        $totalTelegramSubscriptions = is_numeric($totalTelegramSubscriptions) ? $totalTelegramSubscriptions : 0;
        $totalAutoDiscounts = is_numeric($totalAutoDiscounts) ? $totalAutoDiscounts : 0;

        // Calculate the final total payment
        return ($totalProducts + $totalTelegramSubscriptions) - $totalDiscountCode - $totalAutoDiscounts;
    }

    protected static function newFactory(): CartFactory
    {
        return CartFactory::new();
    }
}
