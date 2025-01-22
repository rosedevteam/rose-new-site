<?php

namespace Modules\Reserve\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;

class Reserve extends Model
{
    use HasFactory;

    protected $guarded;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
