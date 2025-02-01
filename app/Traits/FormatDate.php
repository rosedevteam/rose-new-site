<?php

namespace App\Traits;

use Verta;

trait FormatDate
{
    use ConvertNums;

    protected static function formatDate(string $d)
    {
        $expires_at = self::convertNums($d);
        $t = explode(' ', $expires_at);
        $date = explode('/', $t[0]);
        $verta = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        return $verta[0] . '/' . $verta[1] . '/' . $verta[2] . ' ' . $t[1];
    }
}
