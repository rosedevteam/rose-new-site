<?php

namespace Modules\DailyReport\Policies;

use Modules\User\Models\User;

class DailyReportPolicy
{
    // admin-panel
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view-dailyReports');
    }

    public function edit(User $user): bool
    {
        return $user->hasPermissionTo('edit-dailyReports');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-dailyReports');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-dailyReports');
    }
}
