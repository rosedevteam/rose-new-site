<?php

namespace Modules\Discount\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cart\Classes\Helpers\AutoDiscount;
use Modules\Cart\Classes\Helpers\Cart;
use Modules\Discount\Models\Discount;

class DiscountController extends Controller
{
    public function check(Request $request)
    {

        try {
            $validated =  $request->validate([
                'discount' => 'required|exists:discounts,code',
                'cart' => 'required'
            ]);

            $cart = auth()->user()->cart;

            if( ! auth()->check() ) {
                throw new \Exception('برای اعمال کد تخفیف لطفا ابتدا وارد سایت شوید');
            }

            $discount = Discount::where('code' , $validated['discount'])->where('is_active' , 1)->first();

            if ($cart?->discount_code) {
                throw new \Exception('کد تخفیف در حال حاضر روی سبد اعمال شده است');
            }
            if ($discount->discountRecords->count() >= $discount->limit) {
                throw new \Exception('امکان استفاده از این کد تخفیف نیست');
            }

            if( $discount->expires_at < now() ) {
                throw new \Exception('مهلت استفاده از این کد تخفیف به پایان رسیده است');
            }


            if ($cart?->products->count() == 0) {
                throw new \Exception('هیچ محصولی در سبد خرید نیست');
            }

            if(!$cart->products->pluck('id')->intersect($discount->products->pluck('id'))->count()){
                throw new \Exception('کد تخفیف روی این محصولات قابل استفاده نیست');
            }

            $cart->update([
                'discount_code' => $discount->code
            ]);


            toast()->success('موفق' , 'کد تخفیف با موفقیت اعمال شد');
            return back();

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
            $cart = auth()->user()->cart;

            $cart->update([
                'discount_code' => null,
            ]);

            toast()->success('موفق' , 'کد تخفیف با موفقیت حذف شد');
            return back();

        }catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }

    }
}
