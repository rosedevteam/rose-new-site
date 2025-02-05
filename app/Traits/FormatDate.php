<?php

namespace App\Traits;

use Verta;

trait FormatDate
{
    use ConvertNums;

    protected static function formatDateTime(string $d)
    {
        $d = self::convertNums($d);
        $t = explode(' ', $d);
        $date = explode('/', $t[0]);
        $verta = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        return $verta[0] . '/' . $verta[1] . '/' . $verta[2] . ' ' . $t[1];
    }

    protected static function formatDate(string $d)
    {
        $d = self::convertNums($d);
        $date = explode('/', $d);
        $verta = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        return $verta[0] . '/' . $verta[1] . '/';
    }

}
