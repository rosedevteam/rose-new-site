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
    protected $hidden = ['pivot'];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function comments(): ?MorphTo
    {
        if ($this->commentable_type == "\\Modules\\Comment\\Models\\Comment")
            return $this->commentable();
        return null;
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function newFactory(): CommentFactory
    {
        return CommentFactory::new();
    }
}
