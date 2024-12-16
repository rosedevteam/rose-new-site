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

    public function logout(Request $request): Application|Redirector|RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }
}
