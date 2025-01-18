<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Analytics\Database\Factories\IndexValueFactory;

class IndexValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): IndexValueFactory
    // {
    //     // return IndexValueFactory::new();
    // }
}
