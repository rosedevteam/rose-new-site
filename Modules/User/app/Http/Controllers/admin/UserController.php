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
        $roles = Role::all()->select('name', 'id');
        $role_id = request('role');
        $sort_by = request('sort_by');
        $sort_direction = request('sort_direction', 'asc');
        $search = request('search');
        $count = request('count', 10);
        $users = User::with('roles');
        if($role_id){
            $users = $users->whereHas('roles', function ($query) use ($role_id) {
                return $query->where('role_id', $role_id);
            });
        }
        if($sort_by || $sort_direction){
            $users = $users->orderBy($sort_by, $sort_direction);
        }
        if($search){
            $users = $users->where('first_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%');
        }
        $users = $users->paginate($count)->withQueryString();
        return view('user::admin.index', [
            'users' => $users,
            'roles' => $roles,
            'sort_by' => $sort_by,
            'sort_direction' => $sort_direction,
            'search' => $search,
            'role_id' => $role_id,
            'count' => $count,
        ]);
    }

    public function store(Request $request): Application|Redirector|RedirectResponse
    {
        Gate::authorize('create-users');
        try {
            $data = $request->validate([
                'first_name' => 'bail|string|max:255',
                'last_name' => 'bail|string|max:255',
                "phone" => 'bail|required|string|digits:11|unique:users,phone",',
                "role_id" => 'bail|required|string|exists:roles,id'
            ]);
        } catch (\Throwable $th) {
            return redirect(route('admin.user.index'))->withErrors([$th->getMessage()]);
        }
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
