<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Arr;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\User\Models\Billing;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('کاربران');
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

        $data = $request->validate([
            'first_name' => 'bail|string|max:255',
            'last_name' => 'bail|string|max:255',
            "phone" => ['bail', 'required', 'string', 'unique:users,phone', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
        ]);

        try {

            $user = User::query()->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
            ]);

            $user->assignRole('مشتری');
            $after = json_encode(Arr::except($user->toArray(), 'password'), JSON_UNESCAPED_UNICODE);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties(compact('after'))
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
//        if ($user->trashed() && Gate::denies('restore-users')) {
//            abort(404);
//        }
        try {

            $orders = null;
            $billing = null;
            $roles = Role::all()->select('name', 'id');
            $canEdit = Gate::allows('update', $user);
            $canSetRole = Gate::allows('setRole', $user);
            $canDelete = Gate::allows('delete', $user);

            if (Gate::allows('view-orders')) {
                $orders = $user->orders()->orderByDesc('created_at')->get();
            }
            if (Gate::allows('view-billings')) {
                $billing = Billing::orderByDesc('created_at')->first();
            }

            return view('user::admin.show', compact('user', 'orders', 'billing', 'roles', 'canEdit', 'canSetRole', 'canDelete'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(User $user)
    {
        Gate::authorize('update', $user);
//        Gate::authorize('edit-users');
//        if($user->hasPermissionTo('admin-panel') &&
//            (auth()->user()->id != $user->id || !auth()->user()->hasRole('super-admin'))) {
//            throw new AuthorizationException();
//        }
        $userData = request()->validate([
            'first_name' => 'bail|nullable|string|max:255',
            'last_name' => 'bail|nullable|string|max:255',
            'email' => 'bail|nullable|string|email|unique:users,email',
        ]);
        try {

            $billingData = null;
            $userData = array_filter($userData, function ($value) {
                return !is_null($value);
            });
            if (!is_null($billingData)) {
                $billingData = request()->validate([
                    'address' => 'bail|nullable|string|max:255',
                    'city' => 'bail|nullable|string|max:255',
                    'province' => 'bail|nullable|string|max:255',
                    'postal_code' => 'bail|nullable|string|digits:10',
                ]);
                $billingData = array_filter($billingData, function ($value) {
                    return !is_null($value);
                });
                $before = json_encode($user->billing()->first(), JSON_UNESCAPED_UNICODE);
                $user->billing()->update($billingData);
                $after = json_encode($user->billing()->first(), JSON_UNESCAPED_UNICODE);
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($user->billing()->first())
                    ->withProperties(compact('before', 'after'))
                    ->log('ویرایش اطلاعات صورتحساب کاربر');
            }
            $before = json_encode(Arr::except($user->toArray(), 'password'), JSON_UNESCAPED_UNICODE);
            $user->update($userData);
            $after = json_encode(Arr::except($user->toArray(), 'password'), JSON_UNESCAPED_UNICODE);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties(compact('before', 'after'))
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
        Gate::authorize('delete', $user);
//        Gate::authorize('delete-users');
//        if ($user->hasRole('super-admin') || auth()->user()->id == $user->id ||
//            ($user->hasRole('ادمین') && !auth()->user()->hasRole('super-admin'))) {
//            throw new AuthorizationException();
//        }
        try {

            $before = json_encode(Arr::except($user->toArray(), 'password'), JSON_UNESCAPED_UNICODE);
            $user->delete();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(compact('before'))
                ->log('حذف کاربر');
            alert()->success("موفق", "کاربر حذف شد");

            return redirect(route('admin.users.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
    public function setRole(User $user)
    {
        Gate::authorize('setRole', $user);
//        Gate::authorize('set-role');
//        if ($user->hasRole('super-admin') || auth()->user()->id == $user->id ||
//            ($user->hasRole('ادمین') && !auth()->user()->hasRole('super-admin'))) {
//            throw new AuthorizationException();
//        }
        try {

            $data = request()->validate([
                'role_id' => 'bail|required|string|exists:roles,id',
            ]);
            $role = Role::where('id', $data['role_id'])->first()->name;
            if ($role == 'super-admin') {
                return back();
            }

            $before = json_encode($user->getRoleNames(), JSON_UNESCAPED_UNICODE);
            $user->syncRoles($role);
            $after = json_encode($user->getRoleNames(), JSON_UNESCAPED_UNICODE);

            activity()
                ->causedBy(auth()->user())
                ->withProperties(compact('before', 'after'))
                ->log('ویرایش نقش');
            alert()->success('موفق', 'ویرایش نقش با موفقیت انجام شد');

            return back();
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
