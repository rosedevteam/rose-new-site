<?php

namespace Modules\Cart\Classes\Helpers;

use Modules\Cart\Classes\Helpers\Cart;

class AutoDiscount
{
    protected static $fis_Id = 2580;
    protected static $afzayesh_sarmaye_id = 2013;
    protected static $master_fis_id = 23423;

    const DISCOUNT_FIS_AND_AFZAYESH = 75;
    const DISCOUNT_FIS = 50;
    const DISCOUNT_AFZAYESH = 40;

    public static function masterFis($item)
    {
        $hasFisCourse = userHasCourse(self::$fis_Id);
        $hasAfzayeshSarmayeCourse = userHasCourse(self::$afzayesh_sarmaye_id);

        //if master was in cart
        if ($item['product']->id == self::$master_fis_id) {
            //check if user has courses in orders
            if ($hasFisCourse && $hasAfzayeshSarmayeCourse) {
                $item['auto_discount'] = self::DISCOUNT_FIS_AND_AFZAYESH;
                $item['price'] = $item['price'] - ($item['price'] * self::DISCOUNT_FIS_AND_AFZAYESH / 100);

            } elseif ($hasFisCourse) {
                $item['auto_discount'] = self::DISCOUNT_FIS;
//                dd($item['price']);
                $item['price'] = $item['price'] - ($item['price'] * self::DISCOUNT_FIS / 100);

            } elseif ($hasAfzayeshSarmayeCourse) {
                $item['auto_discount'] = self::DISCOUNT_AFZAYESH;
                $item['price'] = $item['price'] - ($item['price'] * self::DISCOUNT_AFZAYESH / 100);
            }
        }

        return $item;
    }
}
