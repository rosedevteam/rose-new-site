<?php

namespace Modules\Podcast\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

// use Modules\Podcast\Database\Factories\PodcastFactory;

class Podcast extends Model
{
    use HasFactory;

    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
