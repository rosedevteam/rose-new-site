<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comment\Models\Comment;
use Modules\Order\Models\Order;
use Modules\Product\Database\Factories\ProductFactory;
use Modules\User\Models\User;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function author(): User
    {
        return $this->belongsTo(User::class)->first();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
