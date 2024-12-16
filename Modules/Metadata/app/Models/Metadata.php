<?php

namespace Modules\Metadata\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Metadata\Database\Factories\MetadataFactory;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Metadata whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
