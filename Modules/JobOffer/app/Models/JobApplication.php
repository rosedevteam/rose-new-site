<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }
}
