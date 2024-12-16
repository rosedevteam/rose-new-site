<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Modules\User\Models\User;

/**
 * 
 *
 * @property int $id
 * @property string $otp
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OtpCode whereUserId($value)
 * @mixin \Eloquent
 */
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
