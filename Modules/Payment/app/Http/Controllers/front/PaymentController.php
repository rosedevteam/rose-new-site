<?php

namespace Modules\Payment\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cart\Models\Cart;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
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

            dd($totalPrice);

            if (\Modules\Cart\Classes\Helpers\Cart::isCartDiscountable()) {
                $discount = \Modules\Cart\Classes\Helpers\Cart::getDiscount();
                $totalPrice = $totalPrice - $discount->amount;
            }

            $orderItems = $cartItems->mapWithKeys(function ($cart) {

                return [$cart['product']->id => ['quantity' => $cart['quantity'], 'price' => $cart['price']]];
            });

            dd($orderItems);

            if ($request->input('address-id') && $request->input('address')){
                $request->request->remove('address-id');
            }

            if (!$request->input('address-id')) {
                $validData = $request->validate([
                    'name' => 'required',
                    'last_name' => 'required',
                    'company' => 'nullable',
                    'city' => 'required',
                    'address' => 'required',
                    'address-id' => 'nullable',
                    'postal_code' => 'required' , 'regex:\b(?!(\d)\1{3})[13-9]{4}[1346-9][013-9]{5}\b',
                    'notes' => 'nullable',
                    'shipping' => 'required'
                ]);
                $address = auth()->user()->addresses()->create([
                    'city_id' => $validData['city'],
                    'address' => $validData['address'],
                    'postal_code' => $validData['postal_code']
                ]);
                auth()->user()->update([
                    'name' => $validData['name'],
                    'last_name' => $validData['last_name'],
                ]);
                $order = auth()->user()->orders()->create([
                    'status' => 'unpaid',
                    'price' => $price,
                    'shipping_id' => $validData['shipping'],
                    'address_id' => $address->id,
                    'notes' => $validData['notes'],
                    'order_code' => rand(1000 , 9999),
                ]);
            }else {
                $validData = $request->validate([
                    'address-id' => 'nullable',
                    'note' => 'nullable',
                    'shipping' => 'required',
                    'notes' => 'nullable'
                ]);
                $address = Address::whereId($validData['address-id'])->first();
                $order = auth()->user()->orders()->create([
                    'status' => 'unpaid',
                    'price' => $price,
                    'shipping_id' => $validData['shipping'],
                    'address_id' => $address->id,
                    'order_code' => rand(1000 , 9999),
                    'notes' => $validData['notes']
                ]);
            }

            $order->products()->attach($orderItems);
            $cookieCart->flush();

            $admins = User::where('is_admin' , 1)->get();

            foreach ($admins as $admin) {
                $order->notify(new NewOrderAdminNotification(
                    $admin->phone ,
                    $order->order_code ,
                    $order->price ,
                    $order->user->name ,
                    $order->address->city->name ,
                    $order->shipping->label
                ));
            }
            return view('payment::cardToCard' , compact('order'));
        }

        alert()->error('خطا', 'متاسفانه مشکلی در ثبت سفارش شما پیش آمده، لطفا دوباره تلاش کنید');
        return back();
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
