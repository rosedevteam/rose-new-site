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
        if($search){
            $users = $users->where('first_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%');
        }
        if ($sort_by || $sort_direction) {
            $users = $users->orderBy($sort_by, $sort_direction);
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
            ]);
        } catch (\Throwable $th) {
            return redirect(route('admin.user.index'))->withErrors([$th->getMessage()]);
        }
        $user = User::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
        ]);
        $user->assignRole('customer');
        return redirect(route('admin.user.index'));
    }

    public function show(User $user): Application|Factory|View
    {
        Gate::authorize('view-users');
        $orders = collect([]);
        if (Gate::allows('view-orders')) {
            $orders = $user->orders()->orderByDesc('created_at')->get();
        }
        return view('user::admin.show', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    public function update(User $user): Application|Redirector|RedirectResponse
    {
        Gate::authorize('edit-users');
        $data = request()->validate([
            'first_name' => 'bail|nullable|string|max:255',
            'last_name' => 'bail|nullable|string|max:255',
            'phone' => 'bail|nullable|string|digits:11|unique:users,phone',
            'email' => 'bail|nullable|string|email|unique:users,email',
        ]);
        $updateData = array();
        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                $updateData[$key] = $value;
            }
        }
        $user->update($updateData);
        return redirect(route('admin.user.show', $user));
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete-users');
        $user->delete();
        return redirect(route('admin.user.index'));
    }

}
