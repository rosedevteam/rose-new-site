<?php

namespace Modules\Discount\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;
use Modules\User\Models\User;


class Discount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

}
