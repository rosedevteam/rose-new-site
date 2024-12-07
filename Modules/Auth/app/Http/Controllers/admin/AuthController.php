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
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function requestOtp(Request $request): Application|Response|Redirector|RedirectResponse
    {
        $phone = $request->validate([
            'phone' => ['bail', 'required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
        ]);
        $user = User::query()->where('phone', $phone)->first();
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
