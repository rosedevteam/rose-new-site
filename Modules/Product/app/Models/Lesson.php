<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Database\Factories\LessonFactory;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     protected static function newFactory(): LessonFactory
     {
          return LessonFactory::new();
     }
}
