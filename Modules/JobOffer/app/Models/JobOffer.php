<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
use Modules\JobApplication\Models\JobApplication;
use Modules\JobOffer\Database\Factories\JobOfferFactory;
use Modules\User\Models\User;

class JobOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function allCategories()
    {
        return Category::where('type', 'joboffer')->get();
    }

    public function category()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    protected static function newFactory()
    {
        return JobOfferFactory::new();
    }
}
