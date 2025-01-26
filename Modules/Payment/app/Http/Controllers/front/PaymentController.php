<?php

namespace Modules\Payment\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Cart\Classes\Helpers\Cart;
use Modules\Order\Models\Order;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        try {
            $validData = $request->validate([
                'use_wallet' => 'nullable'
            ]);

            $cookieCart = Cart::instance(config('services.cart.cookie-name'));
            $cartItems = $cookieCart->all();

            if ($cartItems->count()) {
                $totalPrice = $cookieCart->all()->sum(function($item) {
                    if (!is_null($item['product']->sale_price)) {
                        return ($item['product']->sale_price);
                    } else {
                        return  ($item['product']->price);
                    }
                });


                if (\Modules\Cart\Classes\Helpers\Cart::isCartDiscountable()) {
                    $discount = \Modules\Cart\Classes\Helpers\Cart::getDiscount();
                    $totalPrice = $totalPrice - $discount->amount;
                }

                $orderItems = $cartItems->mapWithKeys(function ($cart) {
                    return [$cart['product']->id => ['quantity' => $cart['quantity'], 'price' => $cart['price']]];
                });

                if(isset($validData['use_wallet'])) {
                    if (auth()->user()->wallet->balance >= 30000) {
                        if (auth()->user()->wallet->balance < $totalPrice) {

                            $wallet_transaction = auth()->user()->wallet->transactions()->create([
                                'description' => 'کسر بابت خرید',
                                'type' => 'debit',
                                'amount' => auth()->user()->wallet->balance,
                            ]);

                            $totalPrice = $totalPrice - $wallet_transaction->amount;

                            $order = auth()->user()->orders()->create([
                                'price' => $totalPrice,
                                'status' => 'pending',
                                'wallet_transaction_id' => $wallet_transaction->id,
                            ]);

                            $order->products()->attach($orderItems);

                        }

                    }else{
                        throw new Exception('کیف پول شما کمتر از 30.000 تومان است');
                    }

                }else {

                    $order = auth()->user()->orders()->create([
                        'price' => $totalPrice,
                        'status' => 'pending'
                    ]);

                    $order->products()->attach($orderItems);

                }



                $cookieCart->flush();

//            return view('payment::cardToCard' , compact('order'));
            }
        }catch (\Exception $exception){
            alert()->error('خطا', $exception->getMessage());
            return back();
        }


    }

    public function callback(Request $request)
    {
        try {
            $payment = Payment::where('resnumber', $request->Authority)->firstOrFail();
            // $payment->order->price
            $receipt = ShetabitPayment::amount($payment->order->price)->transactionId($request->Authority)->verify();

            $payment->update([
                'status' => 1
            ]);

            foreach ($payment->order->products as $product) {
                if (!is_null($product->inventory)) {
                    $product->update([
                        'inventory' => $product->inventory - $product->pivot->quantity
                    ]);
                }
            }
            $payment->order()->update([
                'status' => 'paid'
            ]);

            alert()->success('پرداخت شما موفق بود');
            return redirect(route('profile.orders'));

        } catch (InvalidPaymentException $exception) {
            /**
             * when payment is not verified, it will throw an exception.
             * We can catch the exception to handle invalid payments.
             * getMessage method, returns a suitable message that can be used in user interface.
             **/
            alert()->error($exception->getMessage());
            return redirect(route('profile.orders'));
        }
    }
}
