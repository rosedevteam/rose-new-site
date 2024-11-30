<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Modules\User\Models\User;
use Spatie\Activitylog\Models\Activity;
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
            return view('user::admin.index', compact(
                'users',
                'roles',
                'sort_by',
                'sort_direction',
                'search',
                'role_id',
                'count'
            ));
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
            "phone" => 'bail|required|string|digits:11|unique:users,phone',
            'role_id' => 'bail|integer|exists:roles,id',
        ]);
        try {
            $data['role_id'] = Role::where('id', $data['role_id'])->first()->name;
            $user = User::query()->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
            ]);
            if (!auth()->user()->hasPermissionTo('promote-users')) {
                $data['role_id'] = 'مشتری';
            }
            $user->assignRole($data['role_id']);
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
        if ($user->trashed() && Gate::denies('restore-users')) {
            abort(404);
        }
        try {
            $orders = null;
            $logs = null;
            if (Gate::allows('view-orders')) {
                $orders = $user->orders()->orderByDesc('created_at')->get();
            }
            if (Gate::allows('view-logs')) {
                $logs = Activity::causedBy($user)->orderByDesc('created_at')->get();
            }
            return view('user::admin.show', compact('user', 'orders', 'logs'));
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
        if ($user->hasPermissionTo('admin-panel')
            && !auth()->user()->hasRole('ادمین')
            && auth()->user()->id != $user->id) {
            throw new AuthorizationException();
        }
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

    public function deleted(): View|Factory|Application
    {
        gate::authorize('restore-users');
        try {
            $roles = Role::all()->select('name', 'id');
            $role_id = request('role');
            $sort_by = request('sort_by');
            $sort_direction = request('sort_direction', 'asc');
            $search = request('search');
            $count = request('count', 10);
            $users = User::onlyTrashed()->with('roles');
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
            return view('user::admin.deleted', compact(
                'users',
                'roles',
                'sort_by',
                'sort_direction',
                'search',
                'role_id',
                'count'
            ));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function restore(User $user): RedirectResponse
    {
        Gate::authorize('restore-users');
        try {
            $user->restore();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log('restore');
            return redirect(route('admin.user.index'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
