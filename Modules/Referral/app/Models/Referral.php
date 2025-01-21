<?php

namespace Modules\Referral\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Referral\Database\Factories\ReferralFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;

// use Modules\Referral\Database\Factories\ReferralFactory;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usages()
    {
        return $this->hasMany(ReferralUser::class , 'referral_id');
    }

    protected static function newFactory()
    {
        return ReferralFactory::new();
    }
}
