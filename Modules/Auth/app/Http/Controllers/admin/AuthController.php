<?php

namespace Modules\Auth\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
    public function login(Request $request): Application|Redirector|RedirectResponse
    {
        $validatedData = $request->validate([
            'phone' => 'required|numeric|exists:users,phone',
            'password' => 'required|string|min:8',
        ]);
        Auth::attempt($validatedData);
        return redirect(route('admin.index'));
    }

    public function getOtp($request): JsonResponse
    {
        $validatedData = $request->validate([
            'phone' => 'required|numeric|exists:users,phone',
        ]);
        $user = User::where('phone', $validatedData['phone'])->first();
        Gate::authorize('isAdmin', $user);
        // api call
        return response()->json([
            'success'
        ]);
    }
}
