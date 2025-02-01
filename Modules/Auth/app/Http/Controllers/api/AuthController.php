<?php

namespace Modules\Auth\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Modules\Auth\Models\Otp;
use Modules\User\Models\User;

class AuthController extends Controller
{
    public function up()
    {
        // todo
        $up = true;

        $response = response()->json([
            'up' => $up,
            'auth' => null,
        ]);

        if ($up) $response['auth'] = auth()->check();

        return $response;
    }

    public function auth()
    {
        try {
            $validData = request()->validate([
                'phone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/']
            ]);

            $code = Otp::where('phone', $validData['phone'])->first();

            // when a previous code exists and is not expired
            if ($code && $code->expires_at >= now()) {
                return response()->json([
                    'error' => null,
                ]);
            }

            // delete the previous code if exists
            $code?->delete();

            $code = Otp::create([
                'phone' => $validData['phone'],
                'expires_at' => now()->addMinutes(2),
                'otp' => mt_rand(100000, 999999),
            ]);

            sendVerifySms($code->phone, $code->otp);

            return response()->json([
                'error' => null,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function token()
    {
        try {
            $validData = request()->validate([
                'phone' => "required|exists:otps,phone",
                'otp' => "required",
            ]);

            $code = Otp::where('phone', $validData['phone'])->first();

            // throw if expired
            if ($code->expires_at < now()) {
                throw new \Exception("code expired");
            }

            // throw if wrong code
            if ($code->otp != $validData['otp']) {
                throw new \Exception("wrong code");
            }

            $user = User::where('phone', $validData['phone'])->first();

            if ($user) {
                // login if user exists
                auth()->login($user);

                $token = $user->createToken($validData['phone'])->plainTextToken;

                $code->delete();

                return response()->json([
                    'token' => $token,
                    'is_registered' => true,
                    'error' => null,
                ]);
            }

            // goto register if user doesnt exist
            $code->update(['is_verified' => 1]);

            return response()->json([
                'token' => null,
                "is_registered" => false,
                'error' => null,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'token' => null,
                'is_registered' => null,
            ], 400);
        }
    }

    public function register()
    {
        try {
            $validData = request()->validate([
                'phone' => "exists:otps,phone",
                'first_name' => "required",
                'last_name' => "required",
                'referral_code' => "nullable",
            ]);

            $code = Otp::Where('phone', $validData['phone'])->first();

            // throw if phone is not verified
            if (!$code->is_verified) {
                throw new \Exception("not verified");
            }

            $user = User::create([
                'phone' => $validData['phone'],
                'first_name' => $validData['first_name'],
                'last_name' => $validData['last_name'],
            ]);

            auth()->login($user);

            $code->delete();

            $token = $user->createToken($validData['phone'])->plainTextToken;

            return response()->json([
                'token' => $token,
                'error' => null,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'token' => null,
            ], 400);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json();
    }
}
