<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Database\Factories\OrderFactory;
use Modules\Product\Models\Product;
use Modules\User\Models\User;


class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): User
    {
        return $this->belongsTo(User::class)->first();
    }

    public function product(): Product
    {
        return $this->belongsTo(Product::class)->first();
    }

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}
