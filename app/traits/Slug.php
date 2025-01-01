<?php

namespace App\traits;

trait Slug
{
    public static function getSlug($slug)
    {
        return implode('-', explode(' ', $slug));
    }
}
