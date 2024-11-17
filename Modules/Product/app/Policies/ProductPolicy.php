<?php

namespace Modules\Product\Policies;

use Modules\User\Models\User;

class ProductPolicy
{
    // admin-panel
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view-products');
    }

    public function edit(User $user): bool
    {
        return $user->hasPermissionTo('edit-products');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-products');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-products');
    }
}
