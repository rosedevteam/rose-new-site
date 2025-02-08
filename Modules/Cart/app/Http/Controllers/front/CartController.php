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

        if (auth()->check()) {
            $userProducts = auth()->user()->orders()->where('status', 'completed')->with('products')->get()->pluck('products.*.id')->flatten()->unique()->toArray();
            $productsThatUserHaveAlready = array_intersect($userProducts, auth()->user()->cart->products()->pluck('id')->toArray());

            foreach ($productsThatUserHaveAlready as $productId) {

                //cookie cart
                $cookieItem = $cookieCart->all()->where('product.id', $productId)->first();
                $cookieCart->delete($cookieItem['id']);

                //database cart
                auth()->user()->cart->products()->detach($productId);

                $message = 'محصولاتی که قبلا در آن ثبت نام کردید از سبد شما حذف شدند';
            }

            if (AutoDiscount::masterFis()){
                //todo
                alert()->success(auth()->user()->name() . ' عزیز' , 'شما شامل تخفیف شده اید');
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
                        self::editCartToDatabase($cart, $totalPrice, $userCart);
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

    public function quantityChange(Request $request)
    {
        $data = $request->validate([
            'quantity' => 'required',
            'id' => 'required',
            'cart' => 'required'
        ]);
        $cart = Cart::instance($data['cart']);
        $cart_all = $cart->all();
        $product = $cart_all[$data['id']]['product'];
        $cart_quantity = $cart_all[$data['id']]['quantity'];

        if (!is_null($product->inventory)) {
            if ($product->inventory >= $data['quantity']) {
                if ($data['quantity'] >= $product->min_order_quantity) {
                    if ($cart->has($data['id'])) {
                        $cart->update($data['id'], [
                            'quantity' => $data['quantity']
                        ]);
                        $cart_all = $cart->all();
                        $product = $cart_all[$data['id']]['product'];
                        $discount_percent = $cart_all[$data['id']]['discount_percent'];
                        $cart_quantity = $cart_all[$data['id']]['quantity'];
                        if (!$product->is_on_sale()) {
                            if (!$discount_percent) {
                                $price = $product->price * $cart_quantity;
                            } else {
                                $price = ($product->price - ($product->price * $discount_percent)) * $cart_quantity;
                            }
                        } else {
                            $price = $product->sale_price * $cart_quantity;
                        }
                        $totalPrice = Cart::all()->sum(function ($cart) {
                            if ($cart['discount_percent'] == 0) {
                                if (!is_null($cart['product']->sale_price)) {
                                    return $cart['product']->sale_price * $cart['quantity'];
                                } else {
                                    return $cart['product']->price * $cart['quantity'];
                                }
                            } else {
                                if (!is_null($cart['product']->sale_price)) {
                                    return $cart['product']->sale_price * $cart['quantity'];
                                } else {
                                    return ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
                                }
                            }
                        });
                        return response()->json([
                            'success' => true,
                            'data' => 'به روز رسانی با موفقیت انجام شد',
                            'price' => $price,
                            'total' => $totalPrice
                        ]);
                    }
                    return response()->json([
                        'success' => false,
                        'data' => 'محصول در سبد خرید شما وجود ندارد'
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'data' => 'تعداد انتخابی کمتر از حداقل سفارش میباشد'
                ]);
            }
            return response()->json([
                'success' => false,
                'data' => 'تعداد انتخابی بیش از موجودی انبار میباشد'
            ]);

        } else {
            if ($data['quantity'] >= $product->min_order_quantity) {
                if ($cart->has($data['id'])) {
                    $cart->update($data['id'], [
                        'quantity' => $data['quantity']
                    ]);
                    $cart_all = $cart->all();
                    $product = $cart_all[$data['id']]['product'];
                    $discount_percent = $cart_all[$data['id']]['discount_percent'];
                    $cart_quantity = $cart_all[$data['id']]['quantity'];
                    if (!$product->is_on_sale()) {
                        if (!$discount_percent) {
                            $price = $product->price * $cart_quantity;
                        } else {
                            $price = ($product->price - ($product->price * $discount_percent)) * $cart_quantity;
                        }
                    } else {
                        $price = $product->sale_price * $cart_quantity;
                    }
                    $totalPrice = Cart::all()->sum(function ($cart) {
                        if ($cart['discount_percent'] == 0) {
                            if (!is_null($cart['product']->sale_price)) {
                                return $cart['product']->sale_price * $cart['quantity'];
                            } else {
                                return $cart['product']->price * $cart['quantity'];
                            }
                        } else {
                            if (!is_null($cart['product']->sale_price)) {
                                return $cart['product']->sale_price * $cart['quantity'];
                            } else {
                                return ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
                            }
                        }
                    });
                    return response()->json([
                        'success' => true,
                        'data' => 'به روز رسانی با موفقیت انجام شد',
                        'price' => $price,
                        'total' => $totalPrice
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'data' => 'محصول در سبد خرید شما وجود ندارد'
                ]);
            }
            return response()->json([
                'success' => false,
                'data' => 'تعداد انتخابی کمتر از حداقل سفارش میباشد'
            ]);
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
                if (!is_null($product->sale_price)) {
                    return $product->sale_price;
                } else {
                    return $product->price;
                }
            });

            if (!is_null($cart)) {
                if ($cart->products->count()) {
                    auth()->user()->cart()->update([
                        'total' => $totalPrice
                    ]);
                    $cart->products()->sync($cart->products()->pluck('id')->toArray());
                } else {
                    $cart->delete();
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
