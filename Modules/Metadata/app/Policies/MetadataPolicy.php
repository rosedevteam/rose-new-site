<?php

namespace Modules\Metadata\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MetadataPolicy
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
