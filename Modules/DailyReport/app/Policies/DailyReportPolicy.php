<?php

namespace Modules\DailyReport\Policies;

use Modules\User\Models\User;

class DailyReportPolicy
{
    // admin-panel
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view-daily-reports');
    }

    public function edit(User $user): bool
    {
        return $user->hasPermissionTo('edit-daily-reports');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-daily-reports');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-daily-reports');
    }
}
