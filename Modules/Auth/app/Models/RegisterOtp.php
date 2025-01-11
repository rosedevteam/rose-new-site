<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Auth\Database\Factories\RegisterOtpFactory;

class RegisterOtp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    protected $table = 'register_otp';

    public static function verifyCode($codeId , $code)
    {
        return !!RegisterOtp::where('id' , $codeId)->where('otp' , $code)->where('expired_at', '>', now())->first();
    }

    // protected static function newFactory(): RegisterOtpFactory
    // {
    //     // return RegisterOtpFactory::new();
    // }
}
