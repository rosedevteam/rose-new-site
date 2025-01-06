<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Category\Models\Category;
use Modules\Comment\Models\Comment;
use Modules\Metadata\Models\Metadata;
use Modules\Post\Database\Factories\PostFactory;
use Modules\User\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public static function allCategories()
    {
        return Category::where('type', 'post')->get();
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function metadata()
    {
        return $this->morphOne(Metadata::class, 'metadataable');
    }

    public static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
