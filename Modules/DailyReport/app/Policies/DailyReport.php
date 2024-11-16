<?php

namespace Modules\DailyReport\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DailyReport
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
}
