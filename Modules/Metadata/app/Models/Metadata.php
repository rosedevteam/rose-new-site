<?php

namespace Modules\Metadata\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Metadata\Database\Factories\MetadataFactory;

class Metadata extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): MetadataFactory
    // {
    //     // return MetadataFactory::new();
    // }
}
