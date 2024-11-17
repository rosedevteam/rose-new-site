<?php

namespace Modules\Post\Policies;

use Modules\User\Models\User;

class PostPolicy
{
    // admin-panel
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view-posts');
    }

    public function edit(User $user): bool
    {
        return $user->hasPermissionTo('edit-posts');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-posts');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-posts');
    }
}
