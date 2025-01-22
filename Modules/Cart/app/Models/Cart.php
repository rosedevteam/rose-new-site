<?php

namespace Modules\Cart\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

class Cart extends Model
{

    use HasFactory;

    protected $guarded;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
