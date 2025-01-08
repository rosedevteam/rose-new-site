<?php

namespace Modules\Auth\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Kavenegar\KavenegarApi;
use Modules\Auth\Models\OtpCode;
use Modules\Auth\Models\RegisterOtp;
use Modules\Auth\Notifications\OtpNotification;
use Modules\User\Models\User;

class LoginController extends Controller
{
    public function auth(Request $request)
    {
        try {
            $validData = $request->validate([
                'phone' => ['required' , 'regex:/^09[0|1|2|3][0-9]{8}$/']
            ]);

            $user = User::where('phone' , $validData['phone'])->first();
            if ($user) {
                // generate sms code
                $code = OtpCode::generateCode($user);

                // create session to store sms code in it
                $request->session()->flash('auth', [
                    'user_id' => $user->id
                ]);

                // send sms code to user
                $user->notify(new OtpNotification($user->phone , $code));

                return response()->json([
                    'success' => true,
                    'is_signed_up' => true,
                    'phone' => $validData['phone'],
                ] , 200);
            }else{
                return response()->json([
                    'success' => true,
                    'is_signed_up' => false,
                    'phone' => $validData['phone']
                ] , 200);

//                $code = RegisterOtp::create([
//                    'otp' => mt_rand(100000, 999999),
//                    'phone' => $validData['phone'],
//                    'expired_at' => now()->addMinutes(2)
//                ]);
//                $template="verify";
//                //Send null for tokens not defined in the template
//                //Pass token10 and token20 as parameter 6th and 7th
//
//                $kavenegar = new KavenegarApi(config('services.sms.api'));
//
//                $kavenegar->VerifyLookup($code->phone, $code->otp , '' , '' , $template);


            }

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }

    }


    public function token(Request $request)
    {
        try {
            $validData = $request->validate([
                'otp' => 'required'
            ]);

            $request->session()->reflash();

//            //check auth session exists
            if (!$request->session()->has('auth')) {
                return redirect(route('index'));
            }

            //get user from database with "auth" session
            $user = User::where('id' , $request->session()->get('auth.user_id'))->first();
//            dd($user);
            //check code expire date
            $status = OtpCode::verifyCode($validData['otp'], $user);
            //check auth session exists
            if (!$request->session()->has('auth')) {
                return redirect(route('index'));
            }


            if (!$status) {
                //return back and show error to user
                throw new \Exception('کد وارد شده صحیح نمیباشد' , 400);
            } else {

                //login user by ID
                auth()->loginUsingId($user->id);

                //remove otp code from codes table
                $user->otpCodes()->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'ورود با موفقیت انجام شد',
                    'redirect' => URL::previous()
                ] , 200);

            }
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ] , 400);
        }
    }
}
