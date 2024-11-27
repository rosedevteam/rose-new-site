<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comment\Models\Comment;
use Modules\Post\Database\Factories\PostFactory;
use Modules\User\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function author(): User
    {
        return $this->belongsTo(User::class)->get()[0];
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
