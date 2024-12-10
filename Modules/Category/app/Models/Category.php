<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categoryable()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

}
