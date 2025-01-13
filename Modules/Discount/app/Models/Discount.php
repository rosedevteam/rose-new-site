<?php

namespace Modules\Discount\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;
use Modules\User\Models\User;


class Discount extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

}
