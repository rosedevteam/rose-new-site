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

    protected const OTP_DURATION = 2;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::created(function ($user) {
            OtpCode::create([
                'otp' => $user->generateOtp(),
                'user_id' => $user->id,
            ]);
            Billing::create([
                'user_id' => $user->id,
            ]);
        });
    }

    public function name(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function requestOtp(): void
    {
        $currentCode = $this->otp();
        if ($currentCode->updatedAt() >= now()->subMinutes(self::OTP_DURATION)) {
            $currentCode->update([
                'otp' => $this->generateOtp()
            ]);
        }
    }

    // 0 -> wrongOtp, 1 -> correct, 2 -> expired
    public function checkOtp(string $otp): int
    {
        $currentCode = $this->otp;
        if ($currentCode->updated_at <= now()->subMinutes(self::OTP_DURATION)) {
            return 2;
        } elseif ($currentCode->otp == $otp) {
            return 1;
        } else {
            return 0;
        }
    }

    private function generateOtp(): string
    {
        $newCode = (string)mt_rand(100000, 999999);
        $this->notify(new OtpNotification($this->phone, $newCode));
        return $newCode;
    }

    public function otp(): HasOne
    {
        return $this->hasOne(OtpCode::class);
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
