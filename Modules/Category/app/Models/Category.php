<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Database\Factories\CategoryFactory;
use Modules\JobOffer\Models\JobOffer;
use Modules\User\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function children()
    {
        if (!$this->is_parent) return null;
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function jobOffers()
    {
        return $this->morphedByMany(JobOffer::class, 'categoryable');
    }

    public function parent()
    {
        if($this->is_parent) return null;
        return $this->morphedByMany(Category::class, 'categoryable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

}
