<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Database\Factories\CategoryFactory;
use Modules\JobOffer\Models\JobOffer;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function children()
    {
        if ($this->is_parent) return null;
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function jobOffers()
    {
        return $this->morphedByMany(JobOffer::class, 'categoryable');
    }

    public function parent()
    {
        return $this->morphedByMany(Category::class, 'categoryable');
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

}
