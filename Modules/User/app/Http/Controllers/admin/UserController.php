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
        Gate::authorize('view-users');
        $this->seo()->setTitle('کاربران');
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
            $after = Arr::except($user->toArray(), ['password']);

            self::log($user, compact('after'), 'ساخت کاربر');
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
        $userData = request()->validate([
            'first_name' => 'bail|nullable|string|max:255',
            'last_name' => 'bail|nullable|string|max:255',
            'email' => 'bail|nullable|string|email',
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
                $before = $user->billing()->first()->toArray();
                $user->billing()->update($billingData);
                $after = $user->billing()->first()->toArray();
                self::log($user, compact('after', 'before'), 'ویرایش اطلاعات صورتحساب کاربر');
            }

            $before = Arr::except($user->toArray(), ['password']);
            $user->update($userData);
            $after = Arr::except($user->toArray(), ['password']);

            self::log($user, compact('before', 'after'), 'ویرایش کاربر');
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
        try {

            $before = Arr::except($user->toArray(), ['password']);
            $user->delete();

            self::log(null, compact('before'), 'حذف کاربر');
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
        try {

            $data = request()->validate([
                'role_id' => 'bail|required|string|exists:roles,id',
            ]);
            $role = Role::where('id', $data['role_id'])->first()->name;
            if ($role == 'super-admin') {
                return back();
            }

            $before = $user->getRoleNames();
            $user->syncRoles($role);
            $after = $user->getRoleNames();

            self::log($user, compact('before', 'after'), 'ویرایش نقش');
            alert()->success('موفق', 'ویرایش نقش با موفقیت انجام شد');

            return back();
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
