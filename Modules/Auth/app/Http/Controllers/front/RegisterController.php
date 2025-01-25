<?php

namespace Modules\Auth\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Modules\Auth\Models\RegisterOtp;
use Modules\Referral\Models\Referral;
use Modules\Referral\Notifications\ReferralAfterRegister;
use Modules\User\Models\User;

class RegisterController extends Controller
{
    public function auth(Request $request)
    {
        try {
            $validData = $request->validate([
                'phone' => 'required',
            ]);

            if (RegisterOtp::where('phone', $validData['phone'])->exists()) {
                RegisterOtp::where('phone', $validData['phone'])->first()->delete();
            }

            $code = \Modules\Auth\Models\RegisterOtp::create([
                'otp' => mt_rand(100000, 999999),
                'phone' => $validData['phone'],
                'expired_at' => now()->addMinutes(2)
            ]);

            sendVerifySms($code->phone, $code->otp);

            // create session to store sms code in it
            $request->session()->flash('auth', [
                'code_id' => $code->id
            ]);

            return response()->json([
                'success' => true,
                'phone' => $validData['phone'],
                'message' => 'کد با موفقیت ارسال شد'
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function token(Request $request)
    {
        try {
            $validData = $request->validate([
                'otp' => 'required',
                'phone' => 'required'
            ]);

            $request->session()->reflash();

            //check auth session exists
            if (!$request->session()->has('auth')) {
                return redirect(route('index'));
            }

            $code = RegisterOtp::verifyCode($request->session()->get('auth')['code_id'], $validData['otp']);

            //check auth session exists
            if (!$request->session()->has('auth')) {
                return redirect(route('index'));
            }


            if (!$code) {
                //return back and show error to user
                throw new \Exception('کد وارد شده صحیح نمیباشد', 400);
            } else {

                //remove otp code from codes table
                RegisterOtp::where('id', $request->session()->get('auth')['code_id'])->first()->delete();

                return response()->json([
                    'success' => true,
                    'is_verified' => true,
                    'phone' => $validData['phone']
                ], 200);

            }
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function checkReferralCode(Request $request)
    {
        try {
            $validData = $request->validate([
                'referral_code' => 'required'
            ]);

            $referral = Referral::where('code', $validData['referral_code'])->first();

            return response()->json([
                'success' => true,
                'referral_code' => $referral,
                'message' => 'کد معرف با موفقیت ثبت شد'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function register(Request $request)
    {

        try {
            $validData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'referral_code' => 'nullable'
            ]);

            if (!is_null($validData['referral_code'])) {
                $referral = Referral::where('code', $validData['referral_code'])->first();

                if (!$referral) {
                    throw new \Exception('کد معرف صحیح نمیباشد', 400);
                }
            }

            $user = User::create(\Arr::except($validData, ['referral_code']));

            $user->assignRole('مشتری');

            if (!is_null($validData['referral_code'])) {
                if ($referral->usages->count() < 10) {
                    $referral->usages()->create([
                        'used_by' => $user->id,
                        'signed_up' => 1
                    ]);
                    $referral->user->scores()->create([
                        'score' => 500,
                        'log' => "تکمیل ثبت نام با کد معرف شما",
                        'type' => 'credit'
                    ]);
                    $referral->user->notify(new ReferralAfterRegister(
                        $referral->user->phone,
                        $referral->user->first_name,
                        config('services.referral_scores.score_after_register')
                    ));
                }
            }

            auth()->login($user);


            return response()->json([
                'success' => true,
                'message' => 'ثبت نام با موفقیت انجام شد',
                'redirect' => URL::previous()
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }


}
