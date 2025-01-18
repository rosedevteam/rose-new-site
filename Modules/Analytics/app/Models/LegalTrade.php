<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Analytics\Database\Factories\LegalTradeFactory;

class LegalTrade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): LegalTradeFactory
    // {
    //     // return LegalTradeFactory::new();
    // }
}
