<?php

namespace Modules\Cart\Classes\Helpers;

use Modules\Cart\Classes\Helpers\Cart;

class AutoDiscount
{
    protected static $fis_Id = 2580;
    protected static $afzayesh_sarmaye_id = 2013;
    protected static $master_fis_id = 23423;

    public static function masterFIS()
    {
        $cart = Cart::instance(config('services.cart.cookie-name'));
        if ($cart->all()->count() == 0) {
            return false;
        }
        $cartProductIds = $cart->all()->pluck('product.id')->toArray();
        //check if user has master in cart
        if (!in_array(self::$master_fis_id, $cartProductIds)) {
            return false;
        }

        //check if user has courses in orders
        if (userHasCourse(self::$fis_Id) && userHasCourse(self::$afzayesh_sarmaye_id)) {
            //todo
        } elseif (userHasCourse(self::$fis_Id)) {

        } elseif (userHasCourse(self::$afzayesh_sarmaye_id)) {

        }

        return false;
    }
}
