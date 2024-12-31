<?php

namespace App;

trait Slug
{
    public static function getSlug($slug)
    {
        return implode('-', explode(' ', $slug));
    }
}
