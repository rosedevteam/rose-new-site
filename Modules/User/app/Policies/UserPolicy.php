<?php

namespace Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model)
    {
        if ($user->id == $model->id) {
            return true;
        }
        if (!$user->hasPermissionTo('edit-users')) {
            return false;
        }
        if ($model->hasRole('super-admin')) {
            return false;
        }
        if ($user->hasRole('super-admin')) {
            return true;
        }
        if ($model->hasRole('ادمین')) {
            return false;
        }
        if ($user->hasRole('ادمین')) {
            return true;
        }
        if ($model->hasPermissionTo('admin-panel')) {
            return false;
        }
        return true;
    }

    public function delete(User $user, User $model)
    {
        if (!$user->hasPermissionTo('delete-users')) {
            return false;
        }
        if ($user->id == $model->id) {
            return false;
        }
        if ($model->hasRole('super-admin')) {
            return false;
        }
        if ($user->hasRole('super-admin')) {
            return true;
        }
        if ($model->hasRole('ادمین')) {
            return false;
        }
        if ($user->hasRole('ادمین')) {
            return true;
        }
        if ($model->hasPermissionTo('admin-panel')) {
            return false;
        }
        return true;
    }

    public function setRole(User $user, User $model)
    {
        if (!$user->hasPermissionTo('set-roles')) {
            return false;
        }
        if ($model->hasRole('super-admin')) {
            return false;
        }
        if ($user->hasRole('super-admin')) {
            return true;
        }
        if ($model->hasRole('ادمین')) {
            return false;
        }
        return true;
    }

}
