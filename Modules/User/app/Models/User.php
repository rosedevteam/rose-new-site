<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Models\OtpCode;
use Modules\Auth\Notifications\OtpNotification;
use Modules\Comment\Models\Comment;
use Modules\DailyReport\Models\DailyReport;
use Modules\Order\Models\Order;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function name(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function otpCodes(): HasMany
    {
        return $this->hasMany(OtpCode::class);
    }

    public function billing(): Billing
    {
        return $this->hasOne(Billing::class)->first();
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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
