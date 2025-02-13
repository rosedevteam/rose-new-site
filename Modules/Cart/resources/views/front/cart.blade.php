@component('front.master')
    @section('content')
        <div class="main-sec top-bg">
            <div class="container">
                <input type="hidden" name="cart-name" value="{{config('services.cart.cookie-name')}}" id="cart-name">
                <div class="row rose-py-7">
                    @if($message)
                        <div class="alert alert-warning" role="alert" dir="rtl">
                            {{$message}}
                        </div>
                    @endif
                    <div class="col-md-8">
                        <div class="bg-white br-default p-4">
                            <div class="cart">
                                <h3 class="color-default mb-3 ">جزئیات سفارش</h3>
                                <div class="cart-page-inner">
                                    @auth
                                        @if(auth()->user()->cart?->products->count() > 0)
                                            @foreach(auth()->user()->cart?->products as $product)
                                                <div class="d-flex flex-column course-holder parent-cart-item">

                                                    <div class="d-flex flex-column flex-lg-row">
                                                        <div class="course-thumb">
                                                            <img src="{{$product->image}}" alt="">
                                                        </div>
                                                        <div
                                                            class="details d-flex flex-grow-1 justify-content-around flex-column flex-lg-row">
                                                            <div class="d-flex flex-column w-100 flex-grow-1">
                                                                <h3 class="course-title-th">عنوان سفارش</h3>
                                                                <p class="desc">
                                                                    {{$product->title}}
                                                                </p>
                                                            </div>
                                                            <div class="d-flex flex-column w-100 flex-grow-1">
                                                                <h3 class="course-title-th">مبلغ</h3>
                                                                @if(!$product->is_free)
                                                                    @if(!$product->isOnSale())
                                                                        <span
                                                                            class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                                                                     {{ number_format($product->price) }}
                                                                        تومان
                                                                </span>

                                                                    @else
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center align-items-center my-3">

                                                                    <span
                                                                        class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                                                                {{ number_format($product->sale_price) }}
                                                                        تومان
                                                                </span>
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <span
                                                                        class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                                                                        رایگان
                                                                </span>
                                                                @endif

                                                            </div>
                                                            <div class="d-flex flex-column w-100 flex-grow-1">
                                                                <h3 class="course-title-th">عملیات</h3>
                                                                <p class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                                                                    <a role="button" class="remove-from-cart"
                                                                       data-cart="{{$product['id']}}">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                                             fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M15.5457 21.0038H8.45991C7.28371 21.0038 6.30581 20.0982 6.2156 18.9255L5.25 6.37268H18.7556L17.79 18.9255C17.6998 20.0982 16.7219 21.0038 15.5457 21.0038V21.0038Z"
                                                                                  stroke="#E06983" stroke-width="1.5"
                                                                                  stroke-linecap="round"
                                                                                  stroke-linejoin="round"/>
                                                                            <path d="M20.0028 6.37264H3.99609"
                                                                                  stroke="#E06983"
                                                                                  stroke-width="1.5"
                                                                                  stroke-linecap="round"
                                                                                  stroke-linejoin="round"/>
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M9.18797 2.99622H14.8153C15.4369 2.99622 15.9408 3.50011 15.9408 4.12168V6.37262H8.0625V4.12168C8.0625 3.50011 8.56639 2.99622 9.18797 2.99622Z"
                                                                                  stroke="#E06983" stroke-width="1.5"
                                                                                  stroke-linecap="round"
                                                                                  stroke-linejoin="round"/>
                                                                            <path d="M13.969 10.8745V16.5019"
                                                                                  stroke="#E06983"
                                                                                  stroke-width="1.5"
                                                                                  stroke-linecap="round"
                                                                                  stroke-linejoin="round"/>
                                                                            <path d="M10.0315 10.8745V16.5019"
                                                                                  stroke="#E06983"
                                                                                  stroke-width="1.5"
                                                                                  stroke-linecap="round"
                                                                                  stroke-linejoin="round"/>
                                                                        </svg>
                                                                        حذف
                                                                    </a>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info m-4" role="alert" dir="rtl">
                                                هیچ محصولی در سبد خرید شما نیست
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info m-4" role="alert" dir="rtl">
                                            لطفا وارد حساب کاربری خود شوید
                                        </div>
                                    @endauth

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white br-default p-4">
                            <h3 class="color-default mb-3 ">اطلاعات پرداخت</h3>
                            @php
                                if (auth()->check() && auth()->user()->cart){
                                    $totalPrice = auth()->user()->cart->getTotal();

                                    if (auth()->user()->cart->discount_code) {
                                          $discount = \Modules\Discount\Models\Discount::where('code' , auth()->user()->cart->discount_code)->first();
                                          $totalPrice = $totalPrice - $discount->amount;
                                      }
                                }else {
                                     $totalPrice = \Modules\Cart\Classes\Helpers\Cart::all()->sum(function($item) {
                                          if (!is_null($item['product']->sale_price)) {
                                                  return ($item['product']->sale_price);
                                              } else {
                                                  return  ($item['product']->price);
                                              }
                                      });
                                }



                            @endphp

                            <div class="discount-form-wrapper pb-3">
                                @auth
                                    @if($discount = \Modules\Discount\Models\Discount::where('code' , optional(auth()->user()->cart)->discount_code)->first())
                                        <div class="discount-info"
                                             style="border: 1px solid #e7e7e7; padding: .9rem; border-radius: 5px;">


                                            <div
                                                class="d-flex align-items-center justify-content-between title fw-bold">
                                                <div>
                                                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.5 6.49999H7.5M9.5 6.49999H10.5M12.5 6.49999H13.5M6.5 13.5H7.5M9.5 13.5H10.5M12.5 13.5H13.5M8 2.48599V2.49999C8 3.03042 8.21071 3.53913 8.58579 3.9142C8.96086 4.28927 9.46957 4.49999 10 4.49999C10.5304 4.49999 11.0391 4.28927 11.4142 3.9142C11.7893 3.53913 12 3.03042 12 2.49999L11.999 2.48499H14.5C14.7652 2.48499 15.0196 2.59034 15.2071 2.77788C15.3946 2.96542 15.5 3.21977 15.5 3.48499V16.5C15.5 16.7652 15.3946 17.0196 15.2071 17.2071C15.0196 17.3946 14.7652 17.5 14.5 17.5H12C12 16.9696 11.7893 16.4608 11.4142 16.0858C11.0391 15.7107 10.5304 15.5 10 15.5C9.46957 15.5 8.96086 15.7107 8.58579 16.0858C8.21071 16.4608 8 16.9696 8 17.5H5.5C5.23478 17.5 4.98043 17.3946 4.79289 17.2071C4.60536 17.0196 4.5 16.7652 4.5 16.5V3.48499C4.5 3.21977 4.60536 2.96542 4.79289 2.77788C4.98043 2.59034 5.23478 2.48499 5.5 2.48499L8 2.48599Z"
                                                            stroke="#C9C9C9" stroke-linecap="round"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                    کد تخفیف فعال :
                                                    <span>{{ $discount->code }}</span>
                                                </div>
                                                <a
                                                    class="btn btn-sm btn-danger" onclick="deleteDiscount()">حذف</a>
                                            </div>
                                        </div>
                                    @else
                                        <form class="discount-code-wrapper">
                                            <input type="text" class="form-control b-none" placeholder="کد تخفیف"
                                                   name="discount-code" id="discount-code">
                                            <button class="btn btn-sm btn-default" onclick="addDiscount()">اعمال
                                            </button>
                                        </form>
                                    @endif
                                @endauth

                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <p class="title">
                                    مجموع سبد خرید:
                                </p>

                                <p class="subtitle cart-total">
                                    {{number_format(auth()->user()?->cart?->getTotal())}}
                                    تومان
                                </p>
                            </div>
                            <hr class="m-2" style="color: #c9c9c9">

                            <ul class="p-0 payment-details">

                                @auth
                                    @if($discount = \Modules\Discount\Models\Discount::where('code' , optional(auth()->user()->cart)->discount_code)->first())
                                        <li class=" py-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="title">
                                                    کد تخفیف:
                                                </p>

                                                <p class="subtitle cart-total">
                                                    {{number_format($discount->amount)}}
                                                    -
                                                    تومان
                                                </p>
                                            </div>
                                        </li>
                                        <hr class="m-2" style="color: #c9c9c9">
                                    @endif
                                    @if(auth()->user()->cart?->products->count())
                                        @foreach(auth()->user()->cart?->products as $product)
                                            @if($product->hasAutoDiscount())
                                                <li class=" py-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="title">
                                                            {{json_decode($product->pivot->auto_discount , true)['percent']}}
                                                            %
                                                            تخفیف
                                                        </p>

                                                        <p class="subtitle cart-total">
                                                            {{number_format(json_decode($product->pivot->auto_discount , true)['amount'])}}
                                                            -
                                                            تومان
                                                        </p>
                                                    </div>
                                                    <p class="text-success fw-medium" style="font-size: 14px">
                                                        {{json_decode($product->pivot->auto_discount , true)['desc']}}
                                                    </p>
                                                </li>
                                                <hr class="m-2" style="color: #c9c9c9">
                                            @endif

                                        @endforeach
                                    @endif
                                @endauth
                                <li class="d-flex align-items-center justify-content-between py-3">
                                    <p class="title fw-bold text-black">مجموع پرداختی شما:</p>
                                    <p class="subtitle cart-total text-black fw-bold">
                                        {{ number_format($totalPrice - auth()->user()?->cart?->getTotalAutoDiscounts())}}
                                        تومان
                                    </p>
                                </li>

                            </ul>

                            @auth
                                @include('cart::front.components.channel')
                            @endauth


                            <hr>
                            <h3 class="color-default mb-3 ">درگاه پرداخت</h3>
                            <div class="payments">
                                @auth
                                    @if(auth()->user()->wallet->balance > 0)
                                        <div class="d-flex" style="    width: 100%;
    border: solid 1px #e7e7e7;
    padding: 1rem;
    border-radius: 10px;">
                                            <label class="form-check-label custom-option-content" for="use_wallet">
                                                <span class="d-flex">
                                                       <input class="form-check-input" name="use_wallet" type="checkbox"
                                                              value="true" id="use_wallet" form="payment">
                                                <span class="custom-option-header">
                                                    <span class="h4 mb-0 me-2 d-flex flex-column gap-3">استفاده از کیف پول
                                                       <small class="option-text h5">
                                                           موجودی:
                                                        {{number_format(auth()->user()->wallet->balance)}}
                                                                        تومان
                                                    </small>
                                                    </span>
                                                  </span>
                                                </span>

                                            </label>
                                        </div>

                                    @endif
                                @endauth

                                <div class='col'>
                                    <input type="radio" name="parsian" id="gateway" class="d-none imgbgchk" checked>
                                    <label for="img3">
                                        <img src="{{asset('assets/front/images/parsian.png')}}" alt="Image 3">
                                        <div class="d-flex flex-column  gap-2">
                                            <p class="fw-bold">بانک پارسیان</p>
                                            <p class="fw-light">پرداخت از طریق درگاه بانک پارسیان</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @auth
                                <form action="{{route('payment.do')}}" method="post" id="payment">
                                    @csrf
                                    @method('post')
                                    <button type="submit" class="w-100 btn btn-default">پرداخت</button>
                                </form>
                            @else
                                <a class="btn btn-default w-100" type="button" data-bs-toggle="modal"
                                   data-bs-target="#loginModal">
                                    ورود جهت تسویه حساب
                                </a>
                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
    @section('footer')
        @guest
            <script type="text/javascript">
                window.onload = () => {
                    const myModal = new bootstrap.Modal('#loginModal', {
                        keyboard: false,
                        backdrop: 'static'
                    });

                    myModal.show();
                }
            </script>
        @endguest
    @stop

@endcomponent
