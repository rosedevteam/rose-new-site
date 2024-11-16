<?php

namespace Modules\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Billing\Models\Billing;
use Modules\Comment\Models\Comment;
use Modules\DailyReport\Models\DailyReport;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;


class User extends Model
{
    use HasFactory, Authenticatable, HasRoles;

    protected $guarded = [];

    public function billing(): HasOne
    {
        return $this->hasOne(Billing::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
