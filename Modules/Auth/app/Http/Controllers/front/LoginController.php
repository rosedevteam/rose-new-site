<?php

namespace Modules\Auth\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\traits\CartTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Modules\Auth\Models\OtpCode;
use Modules\Auth\Models\RegisterOtp;
use Modules\Auth\Notifications\OtpNotification;
use Modules\Cart\Classes\Helpers\Cart;
use Modules\User\Models\User;

class LoginController extends Controller
{
    use CartTools;

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
                    'message' => 'کد با موفقیت ارسال شد',
                    'phone' => $validData['phone'],
                ] , 200);
            }else{
                if (RegisterOtp::hasLiveCode()) {
                    throw new \Exception('کد تایید برای شما ارسال شده است. جهت ارسال دوباره کد تایید لطفا صبر کنید');
                }
                return response()->json([
                    'success' => true,
                    'is_signed_up' => false,
                    'phone' => $validData['phone']
                ] , 200);

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
                $cart = Cart::instance(config('services.cart.cookie-name'));

                $totalPrice = $cart->all()->sum(function ($cart) {
                    if (!is_null($cart['product']->sale_price)) {
                        return $cart['product']->sale_price * $cart['quantity'];
                    } else {
                        return $cart['product']->price * $cart['quantity'];
                    }
                });
                //login user by ID
                auth()->loginUsingId($user->id);

                //check if user has cart
                if (auth()->check()) {
                    $userCart = auth()->user()->cart;
                    if (is_null($userCart)) {
                        self::addCartToDatabase($cart , $totalPrice);
                    } else {
                        self::editCartToDatabase($cart , $totalPrice , $userCart);
                    }
                }

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
