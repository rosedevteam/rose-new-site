<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Models\OtpCode;
use Modules\Comment\Models\Comment;
use Modules\DailyReport\Models\DailyReport;
use Modules\Menu\Models\Menu;
use Modules\Order\Models\Order;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;
use Modules\User\Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;


class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory, HasRoles, Notifiable;

    protected $guarded = [];

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

    public function posts()

    {
        return $this->hasMany(Post::class);
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

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
