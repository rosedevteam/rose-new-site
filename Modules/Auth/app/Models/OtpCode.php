<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Modules\User\Models\User;

class OtpCode extends Model
{
    use Prunable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerifyCode($query, $code, $user)
    {
        return !!$user->otpCodes()->whereOtp($code)->where('expired_at', '>', now())->first();
    }

    public function scopeGenerateCode($query, $user)
    {

        if($code = $this->getAliveCodeForUser($user)) {
            $code = $code->otp;
        } else {
            do {
                $code = mt_rand(100000, 999999);
            } while($this->checkCodeIsUnique($user , $code));

            // store the code
            $user->otpCodes()->create([
                'otp' => $code,
                'expired_at' => now()->addMinutes(2)
            ]);
        }

        return $code;
    }

    private function checkCodeIsUnique($user, int $code)
    {
        return !!$user->otpCodes()->whereOtp($code)->first();
    }

    private function getAliveCodeForUser($user)
    {
        return $user->otpCodes()->where('expired_at', '>', now())->first();
    }
}
