<?php

namespace App\Traits;

trait Slug
{
    public static function getSlug($slug)
    {
        return implode('-', explode(' ', $slug));
    }
}
