<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Models\OtpCode;
use Modules\Billing\Models\Billing;
use Modules\Comment\Models\Comment;
use Modules\DailyReport\Models\DailyReport;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory, HasRoles, Notifiable;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::created(function ($user) {
            OtpCode::create([
                'otp' => $this->generateOtp(),
                'user_id' => $user->id,
            ]);
        });
    }

    public function requestOtp(): void
    {
        $currentCode = $this->otp();
        if ($currentCode->updatedAt() <= now()->subMinutes(2)) {
            $currentCode->update([
                'otp' => $this->generateOtp()
            ]);
        }
    }


    private function generateOtp(): string
    {
        return (string)mt_rand(100000, 999999);
    }

    public function otp(): HasOne
    {
        return $this->hasOne(OtpCode::class);
    }

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
