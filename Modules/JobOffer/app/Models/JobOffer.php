<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
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

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    protected static function newFactory()
    {
        return JobOfferFactory::new();
    }
}
