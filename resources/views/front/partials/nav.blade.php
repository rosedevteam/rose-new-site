<section class="rose-nav-wrapper position-relative z-9">
    <div class="container">
        <!--  nav  -->
        <header>
            <nav class="rose-nav">
                <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="mobile-menu-icon">
                        <a data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                           aria-controls="mobileMenu">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5031 4.99887H2.4968" stroke="#323232" stroke-width="1.25"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.83152 10.0008H17.5031" stroke="#323232" stroke-width="1.25"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.5031 15.0028H9.16625" stroke="#323232" stroke-width="1.25"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>


                    </div>
                    <div class="logo">
                        <a href="/">
                            <img src="/assets/front/images/logo.svg" width="156" alt="مجموعه آموزشی رز">
                        </a>
                    </div>
                    <div class="menu">
                        <ul class="rose-menu p-0">
                            @foreach($menus as $menu)
                                @if(!$menu->children->count())
                                    <!--Simple menu-->
                                    <li>
                                        <a href="{{$menu->slug}}">
                                            {{$menu->title}}
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $menu->slug }}">
                                             {{$menu->title}}
                                            <i class="bi bi-chevron-down"></i>
                                        </a>

                                        <!--Submenu menu-->
                                        <ul class="submenu p-0 m-0">
                                            @include('front.partials.submenu' , ['menus' => $menu->children, 'icon' => true])
                                        </ul>
                                    </li>
                                @endif

                            @endforeach
                        </ul>
                    </div>

                    <div class="left d-flex align-items-center justify-content-between gap-3">
                        <div class="header-cart" id="cart-icon">
                            <span class="rose-cart-counter" data-counter="0">{{\Modules\Cart\Classes\Helpers\Cart::instance(config('services.cart.cookie-name'))->all()->count()}}</span>
                            <a href="#" type="button" data-bs-toggle="offcanvas" data-bs-target="#side-cart-modal"
                               aria-controls="offcanvasWithBothOptions">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                                     fill="none">
                                    <path d="M8.99902 10.2849C8.99902 11.9425 10.3427 13.2862 12.0003 13.2862V13.2862C13.6578 13.2862 15.0015 11.9425 15.0015 10.2849"
                                          stroke="#323232" stroke-width="1.28571" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path d="M8.99902 7.71247V7.28372C8.99902 5.62618 10.3427 4.28247 12.0003 4.28247V4.28247C13.6578 4.28247 15.0015 5.62618 15.0015 7.28372V7.71247"
                                          stroke="#323232" stroke-width="1.28571" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M7.25335 7.7124C6.34774 7.7124 5.59823 8.41658 5.54174 9.32042L5.14815 15.618C5.0817 16.6811 5.45767 17.7244 6.187 18.5007C6.91633 19.2771 7.93414 19.7174 8.99933 19.7174H15.0015C16.0667 19.7174 17.0846 19.2771 17.8139 18.5007C18.5432 17.7244 18.9192 16.6811 18.8528 15.618L18.4592 9.32042C18.4027 8.41657 17.6532 7.7124 16.7475 7.7124H7.25335Z"
                                          stroke="#323232" stroke-width="1.28571" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </svg>

                            </a>
                        </div>
                        @auth
                            {{auth()->user()->name()}}
                        @else
                            <a  class="btn btn-default" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                                ورود / ثبت نام
                            </a>
                        @endauth

                    </div>
                </div>
            </nav>
        </header>
        <!--  nav end  -->
    </div>
</section>


<!--Start Of Mobile Menu-->
<div class="offcanvas offcanvas-start p-3" data-bs-scroll="true" tabindex="-1" id="mobileMenu" style="overflow: auto"
     aria-labelledby="offcanvasWithBothOptionsLabel">

    <div class="offcanvas-header justify-content-between ">
        <div class="logo">
            <img src="/assets/front/images/logo.svg" width="156" alt="مجموعه آموزشی رز">
        </div>
        <svg data-bs-dismiss="offcanvas" aria-label="Close" xmlns="http://www.w3.org/2000/svg" width="29" height="28"
             viewBox="0 0 29 28" fill="none">
            <rect x="1.23633" y="0.5" width="27" height="27" rx="13.5" stroke="#E7E4E5"/>
            <path d="M19.4027 14H10.0693" stroke="#423D3E" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16.0693 17.3333L19.4027 14" stroke="#423D3E" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16.0693 10.6666L19.4027 14" stroke="#423D3E" stroke-linecap="round" stroke-linejoin="round"/>
            <script xmlns=""/>
        </svg>

    </div>
    <hr>
    <div class="p-3">
        <div class="menu">

            <ul class="rose-menu-mobile p-0">
                @foreach($menus as $menu)
                    @if(!$menu->children->count())
                        <!--Simple menu-->
                        <li>
                            <a href="{{$menu->slug }}">
                                {{$menu->title}}
                            </a>
                        </li>
                    @else
                        <li class="item-with-submenu">
                            <a href="{{ $menu->slug }}">
                                {{$menu->title}}
                                <i class="bi bi-chevron-down"></i>
                            </a>

                            <!--Submenu menu-->
                            <ul class="submenu p-0 m-0">
                                @include('front.partials.submenu' , ['menus' => $menu->children, 'icon'=> false])
                            </ul>
                        </li>
                    @endif

                @endforeach

            </ul>
        </div>
    </div>

    <hr>

    <div class="canvas-footer">
        <div class="title-with-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M9.9513 12.0486C8.8788 10.9761 8.0703 9.77526 7.53314 8.55701C7.41947 8.29942 7.48639 7.99784 7.6853 7.79892L8.43605 7.04909C9.05114 6.43401 9.05114 5.56409 8.51397 5.02692L7.4378 3.95076C6.72189 3.23484 5.56139 3.23484 4.84547 3.95076L4.2478 4.54842C3.56855 5.22767 3.2853 6.20759 3.46864 7.17926C3.92147 9.57451 5.31297 12.1971 7.55789 14.442C9.8028 16.6869 12.4254 18.0784 14.8206 18.5313C15.7923 18.7146 16.7722 18.4313 17.4515 17.7521L18.0482 17.1553C18.7641 16.4394 18.7641 15.2789 18.0482 14.563L16.973 13.4878C16.4358 12.9506 15.565 12.9506 15.0287 13.4878L14.201 14.3164C14.0021 14.5153 13.7005 14.5823 13.4429 14.4686C12.2246 13.9305 11.0238 13.1211 9.9513 12.0486Z"
                      stroke="#0FABB5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <script xmlns=""/>
            </svg>
            <p>021-91691548</p>
        </div>
        <div class="title-with-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M9.9513 12.0486C8.8788 10.9761 8.0703 9.77526 7.53314 8.55701C7.41947 8.29942 7.48639 7.99784 7.6853 7.79892L8.43605 7.04909C9.05114 6.43401 9.05114 5.56409 8.51397 5.02692L7.4378 3.95076C6.72189 3.23484 5.56139 3.23484 4.84547 3.95076L4.2478 4.54842C3.56855 5.22767 3.2853 6.20759 3.46864 7.17926C3.92147 9.57451 5.31297 12.1971 7.55789 14.442C9.8028 16.6869 12.4254 18.0784 14.8206 18.5313C15.7923 18.7146 16.7722 18.4313 17.4515 17.7521L18.0482 17.1553C18.7641 16.4394 18.7641 15.2789 18.0482 14.563L16.973 13.4878C16.4358 12.9506 15.565 12.9506 15.0287 13.4878L14.201 14.3164C14.0021 14.5153 13.7005 14.5823 13.4429 14.4686C12.2246 13.9305 11.0238 13.1211 9.9513 12.0486Z"
                      stroke="#0FABB5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <script xmlns=""/>
            </svg>
            <p>09388159907</p>
        </div>
    </div>
</div>
<!--End Of Mobile Menu-->


<!--Start Of Side Cart-->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="side-cart-modal"
     aria-labelledby="offcanvasWithBothOptionsLabel">

    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="p-3">
        <div class="side-cart-content">
            <ul class="p-0" id="nav-cart-inner">
                @php
                    $totalPrice = \Modules\Cart\Classes\Helpers\Cart::all()->sum(function ($cart) {
                        if (!is_null($cart['product']->sale_price)) {
                            return $cart['product']->sale_price * $cart['quantity'];
                        } else {
                            return $cart['product']->price * $cart['quantity'];
                        }
                    });
                @endphp
                @foreach(\Modules\Cart\Classes\Helpers\Cart::instance(config('services.cart.cookie-name'))->all() as $cart)
                    <div class="cart-page-inner">
                        <li class="parent-cart-item">
                            <div class="product product-widget  pb-3" style="border-bottom: solid #e7e7e7 1px">
                                <figure class="product-main">
                                    <a href="products/{{$cart['product']->slug}}">
                                        <img alt="" src="{{$cart['product']->image}}" class="product-main-image">
                                    </a>
                                </figure>
                                <div class="product-details">

                                    <div class="product-title">
                                        <h3>
                                            <a href="products/{{$cart['product']->slug}}">
                                                {{$cart['product']->title}}
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="product-price">
                                        <ins class="new-price">{{number_format($cart['price'])}} تومان</ins>
                                    </div>
                                </div>
                                <div class="remove-from-cart" data-cart="{{$cart['id']}}">
                                    <a role="button">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M15.5457 21.0038H8.45991C7.28371 21.0038 6.30581 20.0982 6.2156 18.9255L5.25 6.37268H18.7556L17.79 18.9255C17.6998 20.0982 16.7219 21.0038 15.5457 21.0038V21.0038Z"
                                                  stroke="#E06983" stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M20.0028 6.37264H3.99609" stroke="#E06983"
                                                  stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M9.18797 2.99622H14.8153C15.4369 2.99622 15.9408 3.50011 15.9408 4.12168V6.37262H8.0625V4.12168C8.0625 3.50011 8.56639 2.99622 9.18797 2.99622Z"
                                                  stroke="#E06983" stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M13.969 10.8745V16.5019" stroke="#E06983"
                                                  stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M10.0315 10.8745V16.5019" stroke="#E06983"
                                                  stroke-width="1.5" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
        </div>
        <div class="side-cart-footer">
            <div class="subtotal mb-3 d-flex align-content-center justify-content-between">
                <p>مجموع سبد خرید:</p>
                <p class="cart-total">
                    {{number_format($totalPrice)}} تومان</p>
            </div>
            <div class="side-cart-actions">
                <a class="btn btn-default w-100" href="{{route('cart.show')}}">سبد خرید و تسویه حساب</a>
            </div>
        </div>
    </div>

</div>
<!--End Of Side Cart-->

@include('auth::front.components.auth')
