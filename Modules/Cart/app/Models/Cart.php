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
        return $this->belongsToMany(Product::class)->withPivot('auto_discount');
    }

    public function getTotalAutoDiscounts()
    {
        return $this->products->sum(function ($product){
            return $product->getAutoDiscount();
        });
    }

    public function getTotal()
    {
        return $this->products->sum(function ($product){
            return $product->getPrice();
        });
    }

    public function hasDiscount()
    {
        return !!$this->discount_code;
    }

    protected static function newFactory(): CartFactory
    {
        return CartFactory::new();
    }
}
