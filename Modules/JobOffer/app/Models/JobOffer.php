<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

}
