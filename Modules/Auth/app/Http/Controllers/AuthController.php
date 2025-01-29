<?php

namespace Modules\Auth\Http\Controllers;

class AuthController
{
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
