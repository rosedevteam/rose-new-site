<?php

namespace Modules\Post\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Post
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
