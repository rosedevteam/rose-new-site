<?php

namespace Modules\PageBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\PageBuilder\Database\Factories\PageBuilderFactory;

class PageBuilder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */


    protected $table = 'pagebuilders';
    protected $guarded;

    public function pagebuildarable()
    {
        return $this->morphTo();
    }

    // protected static function newFactory(): PageBuilderFactory
    // {
    //     // return PageBuilderFactory::new();
    // }
}
