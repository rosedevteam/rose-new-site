<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Application|Factory|View
    {
        Gate::authorize('view-users');
        $users = User::paginate(50);
        $roles = Role::all()->select('name', 'id');
        return view('user::admin.index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(Request $request): Application|Redirector|RedirectResponse
    {
        Gate::authorize('create-users');
        $data = $request->validate([
            'first_name' => 'bail|string|max:255',
            'last_name' => 'bail|string|max:255',
            "phone" => 'bail|required|string|numeric|unique:users,phone",',
            "role_id" => 'bail|required|string|exists:roles,id'
        ]);
        $user = User::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
        ]);
        $user->assignRole(Role::query()->where('id', $data['role_id'])->first());
        return redirect(route('admin.user.index'));
    }

    public function show(User $user): Application|Factory|View
    {
        Gate::authorize('view-users');
        return view('user::admin.show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user): Application|Factory|View
    {
        Gate::authorize('edit-users');
        return view('user::admin.edit', [
            'user' => $user,
        ]);
    }

}
