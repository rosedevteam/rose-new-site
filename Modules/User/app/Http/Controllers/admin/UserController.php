<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Application|Factory|View
    {
        Gate::authorize('view-users');
        $data = DB::table('users')->leftJoin('roles', 'users.id', '=', 'roles.id')
            ->select(['users.id', "users.first_name", 'users.last_name', 'users.phone', 'users.email', 'roles.name'])->get();
        return view('user::admin.index', [
            'users' => $data,
            'roles' => Role::all()->pluck('name')
        ]);
    }

    public function store(Request $request): Application|Factory|View
    {
        $data = $request->validate([
            'first_name' => 'bail|string|max:255',
            'last_name' => 'bail|string|max:255',
            "phone" => 'bail|required|string|numeric|length:11|unique:users,phone",',
            "role" => 'bail|required|string|exists:roles,name'
        ]);
        $user = User::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
        ]);
        $user->assignRole($data['role']);
        return redirect(route("admin.user.index"));
    }

}
