<?php

namespace Modules\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Comment\Database\Factories\CommentFactory;
use Modules\User\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function author(): User
    {
        return $this->belongsTo(User::class)->get()[0];
    }

    public static function newFactory(): CommentFactory
    {
        return CommentFactory::new();
    }
}
