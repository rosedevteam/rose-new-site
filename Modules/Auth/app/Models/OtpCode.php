<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class OtpCode extends Model
{
    use Prunable;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function ($otpCode) {
            $otpCode->otp = mt_rand(100000, 999999);
        });
    }
}
