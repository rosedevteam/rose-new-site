<?php

namespace Modules\Cart\Classes\Helpers;

use Modules\Cart\Classes\Helpers\Cart;
use Modules\Discount\Models\Discount;
use Modules\Product\Models\Product;

class AutoDiscount
{
    protected static $fis_Id = 2580;
    protected static $afzayesh_sarmaye_id = 2013;
    protected static $master_fis_id = 23423;
    protected static $jame_bonyadi_boors = 14216;

    const DISCOUNT_FIS_AND_AFZAYESH = 75;
    const DISCOUNT_JAME_BONYADI_BOORS = 75;
    const DISCOUNT_FIS = 50;
    const DISCOUNT_AFZAYESH = 40;


    public static function masterFis()
    {
        $cart = auth()->user()->cart;

        $hasFisCourse = userHasCourse(self::$fis_Id);

        $hasAfzayeshSarmayeCourse = userHasCourse(self::$afzayesh_sarmaye_id);

        $hasDoreJame = userHasCourse(self::$jame_bonyadi_boors);

        $masterFis = Product::where('id' , self::$master_fis_id)->first();

        $masterFisPrice = $masterFis->getPrice();

        if ($cart->hasDiscount()) {
            $discount = Discount::where('code' , $cart->discount_code)->first();

            if (in_array($masterFis->id , $discount->products->pluck('id')->toArray())) {
                $masterFisPrice = $masterFisPrice - $discount->amount;
            }
        }


        //if master was in cart
        if (in_array(self::$master_fis_id, $cart->products()->pluck('id')->toArray())) {
            //check if user has courses in orders

            if ($hasDoreJame) {
                $data = [
                    'productRegularPrice' => $masterFisPrice,
                    'amount' => ($masterFisPrice * self::DISCOUNT_JAME_BONYADI_BOORS) / 100,
                    'percent' => self::DISCOUNT_JAME_BONYADI_BOORS,
                    'desc' => 'هدیه فوق جهت شرکت در دوره جامع بنیادی بورس لحاظ شده است'
                ];

                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => json_encode($data)
                ]);

                return $data;

            }elseif ($hasFisCourse && $hasAfzayeshSarmayeCourse) {

                $data = [
                    'productRegularPrice' => $masterFisPrice,
                    'amount' => ($masterFisPrice * self::DISCOUNT_FIS_AND_AFZAYESH) / 100,
                    'percent' => self::DISCOUNT_FIS_AND_AFZAYESH,
                    'desc' => 'هدیه فوق جهت شرکت در دوره های FIS و افزایش سرمایه لحاظ شده است'
                ];

                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => json_encode($data)
                ]);

                return $data;

            } elseif ($hasFisCourse) {

                $data = [
                    'productRegularPrice' => $masterFisPrice,
                    'amount' => ($masterFisPrice * self::DISCOUNT_FIS) / 100,
                    'percent' => self::DISCOUNT_FIS,
                    'desc' => 'هدیه فوق جهت شرکت در دوره FIS لحاظ شده است'
                ];

                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => json_encode($data)
                ]);

                return $data;

            } elseif ($hasAfzayeshSarmayeCourse) {

                $data = [
                    'productRegularPrice' => $masterFisPrice,
                    'amount' => ($masterFisPrice * self::DISCOUNT_AFZAYESH) / 100,
                    'percent' => self::DISCOUNT_AFZAYESH,
                    'desc' => 'هدیه فوق جهت شرکت در دوره افزایش سرمایه لحاظ شده است'
                ];
                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => json_encode($data)
                ]);

                return $data;

            }
        }

        return false;
    }
}
