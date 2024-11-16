<?php

namespace Modules\Product\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Product
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
