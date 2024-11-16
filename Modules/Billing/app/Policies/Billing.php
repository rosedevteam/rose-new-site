<?php

namespace Modules\Billing\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Billing
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
