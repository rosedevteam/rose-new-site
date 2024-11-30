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
        try {
            $roles = Role::all()->select('name', 'id');
            $role_id = request('role');
            $sort_by = request('sort_by');
            $sort_direction = request('sort_direction', 'asc');
            $search = request('search');
            $count = request('count', 10);
            $users = User::with('roles');
            if ($role_id) {
                $users = $users->whereHas('roles', function ($query) use ($role_id) {
                    return $query->where('role_id', $role_id);
                });
            }
            if ($search) {
                $users = $users->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
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
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function store(Request $request): Application|Redirector|RedirectResponse
    {
        Gate::authorize('create-users');
        $data = $request->validate([
            'first_name' => 'bail|string|max:255',
            'last_name' => 'bail|string|max:255',
            "phone" => 'bail|required|string|digits:11|unique:users,phone",',
        ]);
        try {
            $user = User::query()->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
            ]);
            $user->assignRole('customer');
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log('ساخت کاربر');
            return redirect(route('admin.user.index'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function show(User $user): Application|Factory|View
    {
        Gate::authorize('view-users');
        try {
            $orders = collect([]);
            if (Gate::allows('view-orders')) {
                $orders = $user->orders()->orderByDesc('created_at')->get();
            }
            return view('user::admin.show', [
                'user' => $user,
                'orders' => $orders,
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(User $user): Application|Redirector|RedirectResponse
    {
        Gate::authorize('edit-users');
        $userData = request()->validate([
            'first_name' => 'bail|nullable|string|max:255',
            'last_name' => 'bail|nullable|string|max:255',
            'phone' => 'bail|nullable|string|digits:11|unique:users,phone',
            'email' => 'bail|nullable|string|email|unique:users,email',
        ]);
        $billingData = request()->validate([
            'address' => 'bail|nullable|string|max:255',
            'city' => 'bail|nullable|string|max:255',
            'province' => 'bail|nullable|string|max:255',
            'postal_code' => 'bail|nullable|string|digits:10',
        ]);
        try {
            $userData = array_filter($userData, function ($value) {
                return !is_null($value);
            });
            $billingData = array_filter($billingData, function ($value) {
                return !is_null($value);
            });
            $user->update($userData);
            $user->billing()->update($billingData);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log('ادیت کاربر');
            return redirect(route('admin.user.show', $user));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete-users');
        try {
            $user->delete();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log('حذف کاربر');
            return redirect(route('admin.user.index'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
