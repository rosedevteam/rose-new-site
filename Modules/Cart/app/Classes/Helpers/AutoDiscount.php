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

    public static function masterFis()
    {
        $cart = auth()->user()->cart;
        $hasFisCourse = userHasCourse(self::$fis_Id);
        $hasAfzayeshSarmayeCourse = userHasCourse(self::$afzayesh_sarmaye_id);

        //if master was in cart
        if (in_array(self::$master_fis_id , $cart->products()->pluck('id')->toArray())) {
            //check if user has courses in orders
            if ($hasFisCourse && $hasAfzayeshSarmayeCourse) {
                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => self::DISCOUNT_FIS_AND_AFZAYESH
                ]);

            } elseif ($hasFisCourse) {
                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => self::DISCOUNT_FIS
                ]);

            } elseif ($hasAfzayeshSarmayeCourse) {
                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => self::DISCOUNT_AFZAYESH
                ]);
            }
            return true;
        }

        return false;
    }
}
