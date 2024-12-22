<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Database\Factories\CategoryFactory;
use Modules\JobOffer\Models\JobOffer;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
       return $this->morphedByMany(Post::class, 'categoryable');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'categoryable');
    }

    public function jobOffers()
    {
        return $this->hasOne(JobOffer::class);
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

}
