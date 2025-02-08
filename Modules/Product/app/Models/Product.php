<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Cart\Models\Cart;
use Modules\Category\Models\Category;
use Modules\Channel\Models\Channel;
use Modules\Comment\Models\Comment;
use Modules\Discount\Models\Discount;
use Modules\Metadata\Models\Metadata;
use Modules\Order\Models\Order;
use Modules\PageBuilder\Models\PageBuilder;
use Modules\Product\Database\Factories\ProductFactory;
use Modules\Reserve\Models\Reserve;
use Modules\User\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }


    public static function allCategories()
    {
        return Category::where('type', 'product')->get();
    }

    public function categories()
    {
        return $this->morphToMany(Category::class,  'categoryable');
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function metadata()
    {
        return $this->morphOne(Metadata::class, 'metadataable');
    }


    public function pagebuilder()
    {
        return $this->morphOne(PageBuilder::class, 'pagebuilder');
    }


    public function isOnSale()
    {
        if (!is_null($this->sale_price)) {
            return true;
        }
        return false;
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class);
    }

    public function cart()
    {
        return $this->belongsToMany(Cart::class)->withPivot('auto_discount');
    }
    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
