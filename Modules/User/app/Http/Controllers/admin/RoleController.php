<?php

namespace Modules\User\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-roles');
        try {
            $roles = Role::where('name', '!=', 'super-admin')->with('permissions')->get();
            $permissions = Permission::all()->groupBy(function ($item) {
                return explode('-', $item->name, 2)[1];
            })->map(function ($item) {
                foreach ($item as $permission) {
                    $new[] = explode('-', $permission['name'], 2)[0];
                }
                return $new;
            });
            unset($permissions['panel']);
            return view('user::admin.roles', compact('roles', 'permissions'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('manage-roles');
        $validData = request()->validate([
            'roleName' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);
        try {
            $role = Role::create(['name' => $validData['roleName']]);
            $role->syncPermissions($validData['permissions'] ?? []);
            $after = $role->toArray();
            $this->log($role, compact('after'), 'ساخت نقش');

            alert()->success('موفق', 'نقش با موفقیت ساخته شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function update(Role $role)
    {
        Gate::authorize('manage-roles');
        if ($role->name == 'super-admin') abort(403);
        $validData = request()->validate([
            'edit-roleName' => 'required',
            'edit-permissions' => 'required|array',
            'edit-permissions.*' => 'exists:permissions,name'
        ]);
        try {
            $before = $role->toArray();
            $role->update(['name' => $validData['edit-roleName']]);
            $role->syncPermissions($validData['edit-permissions']);
            $after = $role->toArray();
            $this->log($role, compact('before', 'after'), 'ویرایش نقش');

            alert()->success('موفق', 'نقش با موفقیت ویرایش شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function destroy(Role $role)
    {
        Gate::authorize('manage-roles');
        if ($role->name == 'super-admin') abort(403);
        try {
            $before = $role->toArray();
            $role->delete();

            $this->log(null, compact('before'), 'حذف نقش');
            alert()->success('موفق', 'نقش با موفقیت حذف شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }
}
