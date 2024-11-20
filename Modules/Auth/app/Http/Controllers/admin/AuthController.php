<?php

namespace Modules\Auth\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\User\Models\User;

class AuthController extends Controller
{
    public function requestOtp(Request $request): Application|Redirector|RedirectResponse
    {
        $phone = $request->validate([
            'phone' => 'required|numeric|exists:users,phone',
        ])[0];
        $user = User::where('phone', $phone)->first();
        Gate::authorize('isAdmin', $user);
        $request->session()->put('phone', $phone);
        return redirect(route('admin.otp'));
    }

    public function getOtpPage(Request $request): Factory|View|Application|Redirector|RedirectResponse
    {
        try {
            $phone = $request->session()->get('phone');
            // api call
            return view('auth.otp', ['phone' => $phone]);
        } catch (\Exception $e) {
            return redirect(route('admin.login'));
        }
    }

    public function validateOtp(Request $request): Application|JsonResponse|Redirector|RedirectResponse
    {
        $v = "123456";
        $otp = $request->validate([
            'otp' => 'required|numeric',
        ]);
        if ($otp == $v) {
            $user = User::where('phone', $request->session()->get('phone'))->first();
            Auth::authenticate($user);
            return redirect(route('admin.index'));
        } else {
            return response()->json([
                'error' => 'Invalid OTP',
            ]);
        }
    }
}
