<?php

namespace Modules\User\Policies;

use Modules\User\Models\User;

class UserPolicy
{
    // all
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('view-users');
    }

    public function edit(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('edit-users');
    }

    // admin-panel
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-users');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-users');
    }
}
