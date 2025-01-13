<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Models\OtpCode;
use Modules\Comment\Models\Comment;
use Modules\DailyReport\Models\DailyReport;
use Modules\Discount\Models\Discount;
use Modules\Menu\Models\Menu;
use Modules\Order\Models\Order;
use Modules\Podcast\Models\Podcast;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\StudentReport\Models\StudentReport;
use Modules\User\Database\Factories\UserFactory;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Models\WalletTransaction;
use Spatie\Permission\Traits\HasRoles;


class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory, HasRoles, Notifiable;

    protected $guarded = [];

    protected static function booted()
    {
        parent::booted();

        self::created(function (User $user) {
            $user->wallet()->create();
        });

    }

    public function name(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class);
    }

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function posts()

    {
        return $this->hasMany(Post::class);
    }

    public function studentReports()
    {
        return $this->hasMany(StudentReport::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function podcasts()
    {
        return $this->hasMany(Podcast::class);
    }

    public function discountsCreated()
    {
        return $this->hasMany(Discount::class);
    }

    public function discountsUsed()
    {
        return $this->belongsToMany(Discount::class, table: 'discount_user', foreignPivotKey: 'discount_id');
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
