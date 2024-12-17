<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Modules\Auth\Models\OtpCode;
use Modules\User\Models\User;

class TokenController extends Controller
{
    use SEOTools;
    public function show(Request $request)
    {
        //Set Title Of Page
        $this->seo()
            ->settitle('کد تایید موبایل');

        //check auth session exists : this session created in Modules/Http/Controllers/Admin/LoginController.php Line:48
        if (!$request->session()->has('auth')) {
            return view('auth::admin.login');
        }

        $request->session()->reflash();

        return view('auth::admin.token');
    }

    public function token(Request $request)
    {
        //check auth session exists
        if (!$request->session()->has('auth')) {
            return view('auth::auth.login');
        }

        $request->session()->reflash();

        //get user from database with "auth" session
        $user = User::findOrFail($request->session()->get('auth.user_id'));

        //check code expire date
        $status = OtpCode::verifyCode($request->otp, $user);

        //if user send forget password request this will be true

        //validate the post request
        $request->validate([
            'otp' => 'required'
        ]);

        //check auth session exists
        if (!$request->session()->has('auth')) {
            return view('auth::admin.login');
        }


        if (!$status) {
            //return back and show error to user
            toast('کد صحیح نمیباشد', 'danger');
            return back();
        } else {

            //login user by ID
            auth()->loginUsingId($user->id);

            //remove otp code from codes table
            $user->otpCodes()->delete();

            //check user role and redirect user to profile
//            if ($user->isAdmin()) {
//                return redirect(route('admin.index'));
//            }

            return redirect(route('admin.index'));


        }
    }
}
