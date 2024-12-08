<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\JobOffer\Database\Factories\JobApplicationFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    protected static function newFactory()
    {
        return JobApplicationFactory::new();
    }
}
