<?php

namespace Modules\Auth\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function requestOtp(Request $request): Application|Response|Redirector|RedirectResponse
    {
        $phone = $request->validate([
            'phone' => 'bail|required|numeric|exists:users,phone',
        ]);
        $user = User::where('phone', $phone)->first();
        if (!$user->hasAnyRole(Role::all())) {
            throw new AuthorizationException;
        }
        $request->session()->put('phone', $phone);
        return redirect(route('admin.otp'));
    }

    public function getOtpPage(Request $request): Factory|View|Application|Redirector|RedirectResponse
    {
        try {
            $phone = $request->session()->get('phone')['phone'];
            // api call
            return view('auth::admin.otp', [
                'error' => false,
                'phone' => $phone
            ]);
        } catch (Exception $e) {
            return redirect(route('admin.login'));
        }
    }

    public function validateOtp(Request $request): Factory|View|Application|Redirector|RedirectResponse
    {
        $v = "123456";
        $otp = $request->validate([
            'otp' => 'required|digits:6',
        ]);
        $phone = $request->session()->get('phone')['phone'];
        if ($otp['otp'] == $v) {
            $user = User::where('phone', $phone)->first();
            auth()->loginUsingId($user->id);
//            dd(Auth::login($user));
            return redirect(route('admin.index'));
        } else {
            return view('auth::admin.otp', [
                'error' => true,
                'phone' => $phone,
            ]);
        }
    }
}
