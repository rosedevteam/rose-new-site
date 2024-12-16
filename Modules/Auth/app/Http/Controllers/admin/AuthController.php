<?php

namespace Modules\Auth\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Models\OtpCode;
use Modules\Auth\Notifications\OtpNotification;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('ورود');
        return view('auth::admin.login');
    }

    public function login(Request $request)
    {
        //validate data
        $validData = $request->validate([
            'phone' => ['required', 'exists:users' , 'regex:/^09[0|1|2|3][0-9]{8}$/']
        ]);
        //get user and role from users table
        $user = User::where('phone', $validData['phone'])->first();
        if (!$user?->hasAnyRole(Role::all())) {
            throw new AuthorizationException;
        }

        if ($user) {
            // generate sms code
            $code = OtpCode::generateCode($user);

            // create session to store sms code in it
            $request->session()->flash('auth', [
                'user_id' => $user->id,
                'forget' => false
            ]);

            // send sms code to user
            $user->notify(new OtpNotification($user->phone , $code));

            //send response to front
            return redirect(route('admin.login.token'));

        } else {

            //send error to front
            toast('موبایل اشتباه است' , 'danger');
            return back();

        }

    }

    public function getOtpPage(Request $request): Factory|View|Application|Redirector|RedirectResponse
    {
        try {
            $phone = $request->session()->get('phone')['phone'];
            $user = User::query()->where('phone', $phone)->first();
            $user->requestOtp();

            return view('auth::admin.otp', [
                'error' => false,
            ]);
        } catch (Exception $e) {
            return redirect(route('admin.login'));
        }
    }

    public function validateOtp(Request $request): Factory|View|Application|Redirector|RedirectResponse
    {
        $otp = $request->validate([
            'otp' => "bail|required|digits:6",
        ])['otp'];
        $phone = $request->session()->get('phone')['phone'];
        $user = User::query()->where('phone', $phone)->first();
        $result = $user->checkOtp($otp);
        if ($result == 0) {
            return view('auth::admin.otp', [
                'error' => true,
            ]);
        } elseif ($result == 1) {
            auth()->login($user);
            $user->otp()->delete();
            return redirect(route('admin.index'));
        } else {
            $request->session()->forget('phone');
            return redirect(route('admin.login'));
        }
    }

    public function logout(Request $request): Application|Redirector|RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }
}
