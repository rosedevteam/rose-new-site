<?php

namespace Modules\JobApplication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\JobOffer\Database\Factories\JobApplicationFactory;
use Modules\JobOffer\Models\JobOffer;

class JobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    protected static function newFactory()
    {
        return JobApplicationFactory::new();
    }

}
