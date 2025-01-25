<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Database\Factories\CartFactory;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

// use Modules\Cart\Database\Factories\CartFactory;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    protected $guarded;

     protected static function newFactory(): CartFactory
     {
          return CartFactory::new();
     }
}
