<?php

namespace Modules\User\Policies;

use Modules\User\Models\User;

class UserPolicy
{
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('edit-users');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-users');
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('edit-users');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-users');
    }
}
