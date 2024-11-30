<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}
