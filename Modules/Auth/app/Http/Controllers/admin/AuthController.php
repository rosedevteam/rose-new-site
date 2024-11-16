<?php

namespace Modules\Auth\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): Application|Redirector|RedirectResponse
    {
        $validatedData = $request->validate([
            'phone' => 'required|numeric|exists:users,phone',
            'password' => 'required|string|min:8',
        ]);
        Auth::attempt($validatedData);
        return redirect('/');
    }
}
