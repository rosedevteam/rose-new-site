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

            if( $discount->expires_at < now() ) {
                throw new \Exception('مهلت استفاده از این کد تخفیف به پایان رسیده است');
            }

            if( $discount->users()->count() ) {
                if(! in_array( auth()->user()->id ,  $discount->users->pluck('id')->toArray() ) ) {
                    throw new \Exception('شما قادر به استفاده از این کد تخفیف نیستید');
                }
            }

            if ($cart->all()->count() == 0) {
                throw new \Exception('هیچ محصولی در سبد خرید نیست');
            }

            $cart->addDiscount($discount->code);

            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف با موفقیت اعمال شد'
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
            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف با موفقیت حذف شد'
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }

    }
}
