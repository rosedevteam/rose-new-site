<?php

namespace Modules\Auth\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Modules\Auth\Models\OtpCode;
use Modules\Auth\Models\RegisterOtp;
use Modules\Auth\Notifications\OtpNotification;
use Modules\User\Models\User;

class AuthController extends Controller
{
    public function up()
    {
        // todo disable app api from admin panel
        return response()->json([
            'up' => true
        ]);
    }

    public function auth()
    {
        try {
            $credentials = request()->validate([
                'phone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/']
            ]);
            $user = User::where('phone', $credentials['phone'])->first();

            if ($user) return self::loginPhone($user);
            else return self::registerPhone($credentials['phone']);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    private function loginPhone($user)
    {
        $code = OtpCode::generateCode($user);

        $user->notify(new OtpNotification($user->phone, $code));

        return response()->json([
            'success' => true,
            'registered' => true,
            'message' => 'کد با موفقیت ارسال شد',
        ]);
    }

    private function registerPhone($phone)
    {
        if ($prevCode = RegisterOtp::where('phone', $phone)->exists())
            $prevCode->first()->delete();

        $code = RegisterOtp::create([
            'otp' => mt_rand(100000, 999999),
            'phone' => $phone,
            'expired_at' => now()->addMinutes(2)
        ]);

        sendVerifySms($phone, $code->otp);

        return response()->json([
            'success' => true,
            'registered' => false,
            'message' => 'کد با موفقیت ارسال شد',
        ]);
    }

    public function tokenLogin()
    {
        try {
            $credentials = request()->validate([
                'phone' => 'required|exists:users,phone',
                'otp' => 'required',
            ]);
            $user = User::where('phone', $credentials['phone'])->first();

            if ($user->otpCode == $credentials['otp']) {
                $token = auth()->loginUsingId($user->id);

                $this->respondWithToken($token);

            } else {
                throw new \Exception('کد اشتباه است');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function tokenRegister()
    {
        try {
            $credentials = request()->validate([
                'phone' => 'required|exists:register_otp,phone',
                'otp' => 'required',
            ]);
            $code = RegisterOtp::where('phone', $credentials['phone'])->first();

            if ($code->otp == $credentials['otp']) {
                $code->update([
                    'is_verified' => true,
                ]);
                return response()->json([
                    'success' => true,
                    'registered' => false,
                    'message' => null
                ]);
            } else {
                throw new \Exception('کد اشتباه است');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function register()
    {
        try {
            $credentials = request()->validate([
                'phone' => 'required|exists:register_otp,phone',
                'full_name' => 'required',
                'last_name' => 'required',
                'birthday' => 'required',
            ]);

            $code = RegisterOtp::where('phone', $credentials['phone'])->first();
            if (!$code->is_verified) throw new \Exception();

            $user = User::create($credentials);

            $token = auth()->loginUsingId($user->id);

            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'خروج با موفقیت انجام شد'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
