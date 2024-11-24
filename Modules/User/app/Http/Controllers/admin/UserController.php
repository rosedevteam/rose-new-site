<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class UserController extends Controller
{
    public function index(): Application|Factory|View
    {
        Gate::authorize('view-users');
        return view('user::admin.index');
    }

}
