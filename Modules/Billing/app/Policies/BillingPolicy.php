<?php

namespace Modules\Billing\Policies;

use Modules\Billing\Models\Billing;
use Modules\User\Models\User;

class BillingPolicy
{
    // all
    public function view(User $user, Billing $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('view-billings');
    }

    public function edit(User $user, Billing $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('edit-billings');
    }
}
