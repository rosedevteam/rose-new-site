<?php

namespace Modules\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

// use Modules\Referral\Database\Factories\ReferralUserFactory;

class ReferralUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'referral_user';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class , 'used_by');
    }

    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }
}
