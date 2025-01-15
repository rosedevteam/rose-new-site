<?php

namespace Modules\Discount\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cart\Classes\Helpers\Cart;
use Modules\Discount\Models\Discount;

class DiscountController extends Controller
{
    //todo complete discount system

    public function check(Request $request)
    {

        try {
            $validated =  $request->validate([
                'discount' => 'required|exists:discounts,code',
                'cart' => 'required'
            ]);

            $cart = Cart::instance($validated['cart']);

            if( ! auth()->check() ) {
                throw new \Exception('برای اعمال کد تخفیف لطفا ابتدا وارد سایت شوید');
            }

            $discount = Discount::where('code' , $validated['discount'])->where('is_active' , 1)->first();

            if ($cart->getDiscount()) {
                throw new \Exception('کد تخفیف در حال حاضر روی سبد اعمال شده است');
            }
            if ($discount->discountRecords->count() >= $discount->limit) {
                throw new \Exception('امکان استفاده از این کد تخفیف نیست');
            }

            if( $discount->expires_at < now() ) {
                throw new \Exception('مهلت استفاده از این کد تخفیف به پایان رسیده است');
            }


            if ($cart->all()->count() == 0) {
                throw new \Exception('هیچ محصولی در سبد خرید نیست');
            }


            $cart->addDiscount($discount->code);

            if (!$cart->all()->pluck('discountable')->contains(true)) {
                $cart->addDiscount(null);
                throw new \Exception('کد تخفیف روی این محصولات قابل استفاده نیست');
            }

            $totalPrice = Cart::all()->sum(function ($cart) {
                if (!is_null($cart['product']->sale_price)) {
                    return $cart['product']->sale_price * $cart['quantity'];
                } else {
                    return $cart['product']->price * $cart['quantity'];
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف با موفقیت اعمال شد',
                'discount_code' => $discount->code,
                'discount_amount' => $discount->amount,
                'cart_total'=> $totalPrice
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }

    }

    public function destroy(Request $request)
    {
        try {
            $validData = $request->validate([
                'cart' => 'required'
            ]);

            $cart = Cart::instance($validData['cart']);
            $cart->addDiscount(null);
            $totalPrice = Cart::all()->sum(function ($cart) {
                if (!is_null($cart['product']->sale_price)) {
                    return $cart['product']->sale_price * $cart['quantity'];
                } else {
                    return $cart['product']->price * $cart['quantity'];
                }
            });
            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف با موفقیت حذف شد',
                'cart_total'=> $totalPrice
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }

    }
}
