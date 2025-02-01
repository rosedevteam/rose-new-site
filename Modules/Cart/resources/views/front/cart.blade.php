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
                                    @if($cookieCart->all()->count() > 0)
                                        @foreach($cookieCart->all() as $item)
                                            @if(isset($item['product']))
                                                @php
                                                    $product = $item['product'];
                                                @endphp
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
                                                                       data-cart="{{$item['id']}}">
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
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="alert alert-info m-4" role="alert" dir="rtl">
                                            هیچ محصولی در سبد خرید شما نیست
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white br-default p-4">
                            <h3 class="color-default mb-3 ">اطلاعات پرداخت</h3>
                            @php
                                $totalPrice = $cookieCart->all()->sum(function($item) {
                                    if (!is_null($item['product']->sale_price)) {
                                            return ($item['product']->sale_price);
                                        } else {
                                            return  ($item['product']->price);
                                        }
                                });
                                if ($cookieCart->isCartDiscountable()) {
                                    $discount = $cookieCart->getDiscount();
                                    $totalPrice = $totalPrice - $discount->amount;
                                }
                            @endphp
                            <div class="discount-form-wrapper">
                                @if($discount = $cookieCart->getDiscount())
                                    <div class="discount-info">
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-3 title fw-bold">
                                            کد تخفیف فعال : <span class="text-success">{{ $discount->code }}</span> <a
                                                class="btn btn-sm btn-danger" onclick="deleteDiscount()">حذف</a></div>
                                        <div class="d-flex align-items-center justify-content-between title fw-bold">
                                            مبلغ تخفیف : <span class="text-success">{{ number_format($discount->amount) }} تومان </span>
                                        </div>
                                    </div>
                                @else
                                    <form class="discount-code-wrapper">
                                        <input type="text" class="form-control b-none" placeholder="کد تخفیف"
                                               name="discount-code" id="discount-code">
                                        <button class="btn btn-sm btn-default" onclick="addDiscount()">اعمال</button>
                                    </form>
                                @endif
                            </div>

                            <ul class="p-0 payment-details">

                                <li class="d-flex align-items-center justify-content-between py-3">
                                    <p class="title fw-bold">جمع کل:</p>
                                    <p class="subtitle cart-total">
                                        {{ number_format($totalPrice) }}
                                        تومان
                                    </p>
                                </li>

                            </ul>

                            {{--todo : make this feature after data import--}}
                            @if($cookieCart->all()->pluck('product.title')->contains('دوره تخصصی FIS'))
                                @include('cart::front.components.channel')
                            @endif

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
                                                       <input class="form-check-input" name="use_wallet" type="checkbox" value="true" id="use_wallet" form="payment">
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
                    const myModal = new bootstrap.Modal('#loginModal' , {
                        keyboard: false,
                        backdrop: 'static'
                    });

                    myModal.show();
                }
            </script>
        @endguest
    @stop

@endcomponent
