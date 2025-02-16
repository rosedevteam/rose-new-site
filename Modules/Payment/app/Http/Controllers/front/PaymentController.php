<?php

namespace Modules\Payment\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Cart\Classes\Helpers\Cart;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        try {
            $validData = $request->validate([
                'use_wallet' => 'nullable'
            ]);

            $cookieCart = Cart::instance(config('services.cart.cookie-name'));
            $cart = auth()->user()->cart;
            $cartItems = $cookieCart->all();

            if (!$cart) {
                throw new \Exception('سبد خرید وجود ندارد');
            }

            if ($cart->count()) {

                $totalPrice = $cart->getCartTotalPayment();


                $orderItems = $cart->products->map(function ($product) {
                    return $product->id;
                });


                if (isset($validData['use_wallet'])) {
                    if (auth()->user()->wallet->canUse()) {
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
                                'payment_method' => 'shaparak'
                            ]);

                            $order->products()->attach($orderItems);

                        }

                    } else {
                        throw new Exception('کیف پول شما کمتر از 30.000 تومان است');
                    }

                } else {

                    $order = auth()->user()->orders()->create([
                        'price' => $totalPrice,
                        'status' => 'pending',
                        'payment_method' => 'shaparak'
                    ]);

                    $order->products()->attach($orderItems);

                }

                $invoice = (new Invoice())->amount($totalPrice);

                return Payment::callbackUrl(route('payment.callback'))->purchase($invoice, function ($driver, $transactionId) use ($order, $cookieCart, $invoice , $cart) {

                    $order->payments()->create([
                        'resnumber' => $invoice->getTransactionId(),
                        'status' => 0
                    ]);

                    $cookieCart->flush();

                    $cart->delete();

                })->pay()->render();

            } else {
                throw new Exception('سبد خرید شما خالی است');
            }
        } catch (\Exception $exception) {
            toast()->error('خطا', $exception->getMessage());
            return back();
        }


    }

    public function callback(Request $request)
    {
        try {
            $payment = \Modules\Payment\Models\Payment::where('resnumber', $request->Authority)->firstOrFail();
            $order = $payment->order;
            // $payment->order->price
            $receipt = Payment::amount($payment->order->price)->transactionId($request->Authority)->verify();

            $payment->update([
                'status' => 1
            ]);

            $spot_keys = $order->products->where('spot_player_key' , '<>' , null)->pluck('spot_player_key')->toArray();


            $spot_response = createSpotPlayerLicence(
                auth()->user()->name(),
                $spot_keys,
                $order->user->phone);

            $spot = json_decode($spot_response->getContent(), true);

            auth()->user()->scores()->create([
               'score' => $order->price / 1000,
                'log' => "بابت ثبت سفارش به شماره #$order->id",
                'type' => 'credit'
            ]);

            if ($spot_response->getStatusCode() == 200) {
                $order->update([
                    'status' => 'completed',
                    'spot_player_id' => $spot['id'],
                    'spot_player_licence' => $spot['key'],
                    'spot_player_log' => $spot['message'],
                    'spot_player_watermark' => $order->user->phone

                ]);
            } else {
                $order->update(
                    [
                        'status' => 'pending',
                        'spot_player_log' => $spot['message'],
                        'spot_player_watermark' => $order->user->phone,
                    ]);

            }

            toast()->success('تبریک! پرداخت شما با موفقیت انجام شد');
            return redirect(route('profile.courses'));

        } catch (InvalidPaymentException $exception) {
            /**
             * when payment is not verified, it will throw an exception.
             * We can catch the exception to handle invalid payments.
             * getMessage method, returns a suitable message that can be used in user interface.
             **/

            if ($order->walletTransaction) {
                auth()->user()->wallet->transactions()->create([
                    'description' => 'بازگشت به کیف پول به علت پرداخت ناموفق',
                    'type' => 'credit',
                    'amount' => $order->walletTransaction->amount,
                ]);
            }
            $payment->update([
                'status' => 0
            ]);

            $order->update([
                'status' => 'cancelled'
            ]);

            toast()->error($exception->getMessage());
            return redirect(route('profile.orders'));
        }
    }
}
