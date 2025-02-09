<?php

namespace Modules\Cart\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\traits\CartTools;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Modules\Cart\Classes\Helpers\AutoDiscount;
use Modules\Cart\Classes\Helpers\Cart;
use Modules\Product\Models\Product;

class CartController extends Controller
{

    use SEOTools, CartTools;

    public function cart()
    {
        $this->seo()->setTitle('سبد خرید');

        $cookieCart = Cart::instance(config('services.cart.cookie-name'));
        $message = null;

        if (auth()->check() && auth()->user()->cart) {
            $userProducts = auth()->user()->orders()->where('status', 'completed')->with('products')->get()->pluck('products.*.id')->flatten()->unique()->toArray();
            $productsThatUserHaveAlready = array_intersect($userProducts, auth()->user()->cart?->products()->pluck('id')->toArray());

            foreach ($productsThatUserHaveAlready as $productId) {

                //cookie cart
                $cookieItem = $cookieCart->all()->where('product.id', $productId)->first();
                $cookieCart->delete($cookieItem['id']);

                //database cart
                auth()->user()->cart->products()->detach($productId);

                $message = 'محصولاتی که قبلا در آن ثبت نام کردید از سبد شما حذف شدند';
            }

            if ($autoDiscount = AutoDiscount::masterFis()){
                toast()->success(number_format($autoDiscount['amount']) . ' تخفیف' , $autoDiscount['desc']);
            }
        }

        return view('cart::front.cart', compact('cookieCart'))->with('message', $message);
    }


    public function addToCart(Product $product, Request $request)
    {
        try {
            $validData = $request->validate([
                'quantity' => 'required|integer'
            ]);

            $cart = Cart::instance(config('services.cart.cookie-name'));

            if ($cart->has($product)) {
                throw new \Exception('محصول مورد از قبل در سبد خرید وجود دارد');
            } else {
                $cart->put(
                    [
                        'quantity' => $validData['quantity'],
                    ],
                    $product
                );
                $totalPrice = Cart::all()->sum(function ($cart) {
                    if (!is_null($cart['product']->sale_price)) {
                        return $cart['product']->sale_price * $cart['quantity'];
                    } else {
                        return $cart['product']->price * $cart['quantity'];
                    }
                });

                if (auth()->check()) {
                    $userCart = auth()->user()->cart;
                    if (is_null($userCart)) {
                        self::addCartToDatabase($cart, $totalPrice);
                    } else {
                        self::editCartToDatabase($cart);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'محصول مورد نظر به سبد خرید اضافه شد',
                    'count' => $cart->all()->count(),
                    'added_item' => $product,
                    'added_item_id' => $cart->get($product)['id'],
                    'cart_total_price' => $totalPrice
                ], 200);
            }

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }

    }

    public function deleteFromCart($id)
    {
        try {
            $cart = auth()->user()->cart;
            $cookieCart = Cart::instance(config('services.cart.cookie-name'));

            //delete from database
            $cart->products()->detach($id);

            //delete from cookie
            if (!is_null($cookieCart->all()->where('product.id' , $id)->first())) {
                $cookieCart->delete($cookieCart->all()->where('product.id' , $id)->first()['id']);
            }

            $totalPrice = $cart->products->sum(function ($product) {
                return $product->getPrice();
            });

            if (!is_null($cart)) {
                if ($cart->products->count()) {
                    $cart->update([
                        'total' => $totalPrice
                    ]);
                    $cart->products()->sync($cart->products()->pluck('id')->toArray());
                } else {
                    $cart->delete();
                    $totalPrice = 0;
                }

            }
            return response()->json([
                'success' => true,
                'total' => $totalPrice,
                'count' => $cart->products->count(),
                'message' => 'محصول با موفقیت از سبد خرید حذف شد'
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

}
