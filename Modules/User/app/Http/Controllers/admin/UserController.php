<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('view-users');
        try {
            $roles = Role::all()->select('name', 'id');
            $role_id = request('role');
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $search = request('search');
            $count = request('count', 50);
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
            $users = $users->orderBy($sort_by, $sort_direction);
            $users = $users->paginate($count)->withQueryString();
            return view('user::admin.index', compact(
                'users',
                'roles',
                'search',
                'sort_direction',
                'sort_by',
                'role_id',
                'count'
            ));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        Gate::authorize('create-users');
        try {
            $data = $request->validate([
                'first_name' => 'bail|string|max:255',
                'last_name' => 'bail|string|max:255',
                "phone" => ['bail', 'required', 'string', 'unique:users,phone', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
                'role_id' => 'bail|integer|exists:roles,id',
            ]);
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
                ->withProperties($data)
                ->log('ساخت کاربر');
            alert()->success("موفق", "کاربر با موفقیت ساخته شد");
            return redirect(route('admin.users.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function show(User $user)
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
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(User $user)
    {
        Gate::authorize('edit-users');
        try {
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
                ->withProperties([$userData, $billingData])
                ->log('ویرایش کاربر');
            alert()->success("موفق", "با موفقیت انجام شد");
            return redirect(route('admin.users.show', $user));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
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
            alert()->success("موفق", "کاربر حذف شد");
            return redirect(route('admin.users.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

//    public function deleted()
//    {
//        gate::authorize('restore-users');
//        try {
//            $roles = Role::all()->select('name', 'id');
//            $role_id = request('role');
//            $sort_by = request('sort_by');
//            $sort_direction = request('sort_direction', 'asc');
//            $search = request('search');
//            $count = request('count', 10);
//            $users = User::onlyTrashed()->with('roles');
//            if ($role_id) {
//                $users = $users->whereHas('roles', function ($query) use ($role_id) {
//                    return $query->where('role_id', $role_id);
//                });
//            }
//            if ($search) {
//                $users = $users->where('first_name', 'like', '%' . $search . '%')
//                    ->orWhere('last_name', 'like', '%' . $search . '%')
//                    ->orWhere('email', 'like', '%' . $search . '%')
//                    ->orWhere('phone', 'like', '%' . $search . '%');
//            }
//            if ($sort_by || $sort_direction) {
//                $users = $users->orderBy($sort_by, $sort_direction);
//            }
//            $users = $users->paginate($count)->withQueryString();
//            return view('user::admin.deleted', compact(
//                'users',
//                'roles',
//                'sort_by',
//                'sort_direction',
//                'search',
//                'role_id',
//                'count'
//            ));
//        } catch (\Throwable $th) {
//            alert()->error("خطا", $th->getMessage());
//            return back();
//        }
//    }

//    public function restore(User $user)
//    {
//        Gate::authorize('restore-users');
//        try {
//            $user->restore();
//            activity()
//                ->causedBy(auth()->user())
//                ->performedOn($user)
//                ->log('لغو حذف کاربر');
//            alert()->success("موفق", 'با موفقیت انجام شد');
//            return redirect(route('admin.users.index'));
//        } catch (\Throwable $th) {
//            alert()->error("خطا", $th->getMessage());
//            return back();
//        }
//    }
}
