@component('front.master')
    @section('content')
        <div class="main-sec top-bg">
            <div class="container">

                <!--top nav product-->
                <div class="single-product-nav mb-5 mt-3">
                    <ul class="p-0">
                        <li>
                            <a href="#desc">توضیحات</a>
                        </li>
                        <li>
                            <a href="#preview">
                                ویدیو معرفی
                            </a>
                        </li>
                        <li>
                            <a href="#lessons">
                                سرفصل ها
                            </a>
                        </li>
                        <li>
                            <a href="#teacher">
                                مدرس
                            </a>
                        </li>
                        <li>
                            <a href="#faq">
                                سوالات متداول
                            </a>
                        </li>
                        <li>
                            <a href="#comments">
                                نظرات
                            </a>
                        </li>

                    </ul>
                </div>
                <!--top nav product wns-->


                    @if(!$product->is_free)
                    <div class="bg-white br-default p-5">
                        <div class="row gx-5">
                            <div class="col-md-7 align-self-center">
                                <div class="product-short-details d-flex flex-column align-items-start gap-4">
                                    <h1>{{$product->title}}</h1>
                                    <p class="short-desc">
                                        {{$product->short_description}}
                                    </p>


                                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-between w-100 align-items-center my-4 my-lg-0">
                                        <!--Add To Cart Button-->
                                        <a href="#" class="btn btn-default">ثبت نام در دوره</a>
                                        <!--Add To Cart Button End-->

                                        <div class="product-price mt-4 mt-lg-0">
                                            @if($product->isOnSale())
                                                @php
                                                    $discount_percent = (($product->price - $product->sale_price) / $product->price) * 100
                                                @endphp
                                                <span class="discount-badge mb-3">
                                                    {{round($discount_percent)}} %
                                                    تخفیف
                                                </span>
                                                <p class="old-price">{{number_format($product->price)}}
                                                    <span class="prefix">تومان</span>
                                                </p>
                                                <p class="new-price">{{number_format($product->sale_price)}}
                                                    <span class="prefix">تومان</span>
                                                </p>

                                            @else
                                                <p class="new-price">{{number_format($product->price)}}
                                                    <span class="prefix">تومان</span>
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md-5">
                                <img src="{{$product->image}}" alt="" class="br-default">
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row gx-5">
                        <h1 class="mb-3">{{$product->title}}</h1>
                        <div class="col-md-4 ">
                            <div class="bg-white br-default h-100">
                                <ul class=" rose-playlist-course ">
                                    @if($product->lessons->count())
                                        @foreach($product->lessons as $lesson)
                                            <li>
                                                <a class="select-video" data-video-src="{{$lesson->file}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                                         fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                                              stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                                              stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                        <script xmlns=""/>
                                                    </svg>
                                                    {{$lesson->title}}
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info m-4" role="alert" dir="rtl">
                                            هنوز درسی برای این دوره ارائه نشده و دوره در حال ظبط است
                                        </div>
                                    @endif

                                </ul>

                            </div>
                        </div>
                        @auth
                            <div class="col-md-8">
                                <video class="rose-video-player" width="100%" src="" controls></video>
                            </div>
                        @else
                            <div class="col-md-8">
                                <div style="background: url({{$product->image}})" class="h-100 br-default">
                                    <div style="backdrop-filter: blur(30px)" class="br-default d-flex align-items-center justify-content-center h-100 w-100">
                                        <a class="btn btn-default" href="#">
                                            ثبت نام و مشاهده دوره
                                        </a>
                                    </div>
                                </div>
{{--                                <img class="br-default" style="filter: blur(2px)" src="{{$product->image}}" alt="">--}}
                            </div>
                        @endauth

                    </div>

                    @endif




                @if($product->attributes->count())
                    <div class="my-5">
                        <div class="row">
                            @foreach($product->attributes as $attr)
                                <div class="col-md-3">
                                    <div class="icon-box-inline">
                                        <div class="content">
                                            <h3 class="title">{{$attr->title}}</h3>
                                            <p class="desc">{{$attr->subtitle}}</p>
                                        </div>
                                        <img src="{{$attr->icon}}" alt="{{$attr->title}}">

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="bg-white p-4 br-default">
                            @if($product->pagebuilder)
                                {!! $product->pagebuilder->content !!}
                            @else
                                {!! $product->content !!}
                            @endif
                        </div>

                        <div class="bg-white br-default p-4 mt-4">
                            <!--Start Of Comments Section-->
                            <div class="comments" id="comments">
                                <div class="title-box no-line">
                                    <div class="title-wrapper">
                                        <h3 class="title title-line">
                                            <img src="{{asset('assets/front/images/comment-woo.svg')}}" alt="">
                                            نظرات
                                        </h3>
                                    </div>
                                </div>
                                <ul>
                                    @if($product->comments->count())
                                        @foreach($product->comments->where('status' , 'approved') as $comment)
                                            <li class="comment-item">
                                                <div class="comment-details">
                                                    <div class="comment-user-date">
                                                        <span class="user-name"><a href="#">{{$comment->user->first_name . ' ' . $comment->user->last_name}}</a></span>
                                                        <span class="comment-date">{{Verta::instance($comment->created_at)->formatJalaliDate()}}</span>
                                                    </div>
                                                    <div class="comment-text">
                                                        <p>{{$comment->content}}</p>
                                                    </div>
                                                    <div class="reply mt-3">
                                                        <a href="#" class="reply-button mt-3">
                                                            <i class="bi bi-reply"></i>
                                                            پاسخ
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif


                                </ul>
                                @auth
                                    <form action="#" class="post-comment br-default">
                                        <h3 class="mt-4 mb-4">نظر خود را بنویسید</h3>
                                        <textarea rows="5" placeholder="نظر خود را بنویسید..." class="form-control mt-4"></textarea>
                                        <input type="submit" value="ارسال" class="btn btn-default  mt-4 ">
                                    </form>

                                @else
                                    <div class="alert alert-info" role="alert">
                                        جهت ثبت نظر ابتدا وارد حساب کاربری خود شوید
                                    </div>
                                @endauth

                            </div>
                            <!--End Of Comments Section-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-4 br-default single-product-sidebar">
                            <img src="assets/images/fis.jpg" alt="" class="br-default">

                            <div class="product-sidebar-details mt-4">
                                <h3>دوره مستر FIS</h3>
                                <p class="text-justify">
                                    سیستم معاملاتی FIS (Financial Investing System) یک سیستم منحصر به فرد، توسط دکتر بردیا خسروانی،
                                    مدرس برجسته بازارهای مالی با 15 سال سابقه ی درخشان، طراحی شده است تا راه را برای سرمایه‌گذاران
                                    در جهت کسب سود پایدار و کم‌ریسک، ایجاد درآمد غیرفعال و بازنشستگی زودهنگام در بورس ایران هموار
                                    کند.

                                </p>
                                <!--Add To Cart Button-->
                                <a href="#" class="btn btn-default w-100 mt-4">ثبت نام در دوره</a>
                                <!--Add To Cart Button End-->
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @endsection
    @section('footer')
        <script src="{{asset('assets/front/js/rose-video-player.js')}}"></script>
    @stop

@endcomponent

