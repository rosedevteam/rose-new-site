<?php

namespace Modules\Cart\Classes\Helpers;

use Modules\Cart\Classes\Helpers\Cart;
use Modules\Discount\Models\Discount;
use Modules\Product\Models\Product;
use function Laravel\Prompts\select;

class AutoDiscount
{
    protected static $fis_Id = 2580;
    protected static $afzayesh_sarmaye_id = 2013;
    protected static $master_fis_id = 23423;
    protected static $jame_bonyadi_boors = 14216;

    protected static $old_masir = 3098;
    protected static $new_masir = 27989;

    const DISCOUNT_FIS_AND_AFZAYESH = 75;
    const DISCOUNT_JAME_BONYADI_BOORS = 75;
    const DISCOUNT_FIS = 50;
    const DISCOUNT_AFZAYESH = 40;
    const DISCOUNT_MASIR = 30;


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
                    'desc' => 'تخفیف شرکت در دوره جامع بنیادی بورس'
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
                    'desc' => 'تخفیف شرکت در دوره های FIS و افزایش سرمایه'
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
                    'desc' => 'تخفیف شرکت در دوره FIS'
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
                    'desc' => 'تخفیف شرکت در دوره افزایش سرمایه '
                ];
                $cart->products()->updateExistingPivot(self::$master_fis_id, [
                    'auto_discount' => json_encode($data)
                ]);

                return $data;

            }
        }

        return false;
    }

    public static function masirServatSaz()
    {
        $cart = auth()->user()->cart;

        $hasMasirCourse = userHasCourse(self::$old_masir);

        $newMasir = Product::where('id' , self::$new_masir)->first();

        $newMasirPrice = $newMasir->getPrice();

        if ($cart->hasDiscount()) {
            $discount = Discount::where('code' , $cart->discount_code)->first();

            if (in_array($newMasir->id , $discount->products->pluck('id')->toArray())) {
                $newMasirPrice = $newMasirPrice - $discount->amount;
            }
        }

        //if new masir was in cart
        if (in_array(self::$new_masir, $cart->products()->pluck('id')->toArray())) {
            if ($hasMasirCourse) {
                $data = [
                    'productRegularPrice' => $newMasirPrice,
                    'amount' => ($newMasirPrice * self::DISCOUNT_MASIR) / 100,
                    'percent' => self::DISCOUNT_MASIR,
                    'desc' => 'تخفیف شرکت در دوره مسیر ثروت ساز '
                ];

                $cart->products()->updateExistingPivot(self::$new_masir, [
                    'auto_discount' => json_encode($data)
                ]);

                return $data;
            }
        }

        return false;
    }

}
