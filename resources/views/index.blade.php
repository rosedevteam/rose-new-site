@component('front.master')
    @section('content')
        <!--Hero section-->

        <div class="main-sec top-bg">
            <div class="container">

                <!--Hero section title-->
                <section class="row mt-4 ">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="hero">
                            <a href="" class="btn btn-default-outline btn-sm br-4 mt-5 mb-5">مرجع آموزش بورس و حسابداری</a>
                            <div id="textSlider">
                                <div class="iamCol">
                                    <p>شـــــروع قـــدرتمند در</p>
                                </div>
                                <div class="slideCol">
                                    <div class="scroller">
                                        <div class="inner">
                                            <p>بــازار هــــــــای مــــــالـی</p>
                                            <p>مــسیر سـرمایه‌گذاری</p>
                                            <p>زنـــــــــــدگــــــی مــــــالـی</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <p class="desc">مجموعه آموزشی رز به طور تخصصی در بحث آموزش حوزه مالی (بازار های مالی و حسابداری) و
                                روانشناسی مالی فعال است و تنها رسالت ما آموزش و بالا بردن سطح دانش افراد می‌باشد.</p>
                            <div class="d-flex gap-2">
                                <a href="/retirement-in-7-years" class="btn btn-default btn-hero">بازنشستگی در 7 سال</a>
                                <a href="{{ route("products.index") }}" class="btn btn-outline-secondary btn-hero">دوره
                                    ها</a>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </section>
                <!--Hero section title End-->

                <!--Video Section-->
                <section class="d-flex mt-5 gap-3">

                    <!--slider desktop right-->
                    <div class="flex-grow-1 verticalcolumnone d-none d-md-block">
                        <div id="slider-right" class="slider-container d-flex justify-content-end">
                            <div class="slider">

                                <div class="slide">
                                    +15۰۰۰
                                    <br>
                                    دانشجو
                                </div>
                                <div class="slide">
                                    +10
                                    <br>
                                    دوره آموزشی
                                </div>
                                <div class="slide">
                                    پــــشتیبانی 24
                                    <br>
                                    ســــــاعته
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--slider desktop right end-->

                    <!--Video Box-->
                    <div class="flex-grow-1 ">
                        <video width="100%" class="br-default" controls poster="assets/front/images/Thumbnail-min.png">
                            <source src="movie.mp4" type="video/mp4">
                        </video>
                    </div>
                    <!--Video Box End-->

                    <!--slider desktop left-->
                    <div class="flex-grow-1 verticalcolumnone d-none d-md-block">
                        <div id="slider-left" class="slider-container d-flex ">
                            <div class="slider">
                                <div class="slide">
                                    ۱۳ سال
                                    <br>
                                    تجربه کاری
                                </div>
                                <div class="slide">
                                    معرفی به کار
                                    <br>
                                    بعد از آموزش
                                </div>
                                <div class="slide">
                                    مرجع آموزش
                                    <br>
                                    طلا و نقره
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--slider desktop left end-->

                </section>
                <!--Video Section End-->

                <!--Hero section mobile slider-->
                <section class="mobile-hero-slider d-block d-md-none mt-4">
                    <div class="owl-carousel owl-theme hero">
                        <div class="item">
                            <div class="slide">
                                +15۰۰۰
                                <br>
                                دانشجو
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                +10
                                <br>
                                دوره آموزشی
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                پــــشتیبانی 24
                                <br>
                                ســــــاعته
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                ۱۳ سال
                                <br>
                                تجربه کاری
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                معرفی به کار
                                <br>
                                بعد از آموزش
                            </div>
                        </div>
                        <div class="item">
                            <div class="slide">
                                مرجع آموزش
                                <br>
                                طلا و نقره
                            </div>
                        </div>
                    </div>
                </section>
                <!--Hero section mobile slider end-->

                <!--Info Boxes-->
                <section class="rose-my pb-5">
                    <h2 class="rose-sec-title text-center mb-5">ارزش های مجموعه آموزشی رز</h2>
                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div class="rose-icon-box-wrapper btn btn-4">
                                <div class="icon">
                                    <img class="left" src="assets/front/images/left-info-box.svg">
                                    <img class="right" src="assets/front/images/right-info-box.svg">
                                    <img data-lazyloaded="1" src="assets/front/images/book-1.svg" decoding="async"
                                         data-src="assets/front/images/book-1.svg" alt="">
                                </div>
                                <div class="title">
                                </div>
                                <div class="description">
                                    <p>آموزش تخصصی، کاربردی و تمرین محور و بدون پیش نیاز</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rose-icon-box-wrapper btn btn-4">
                                <div class="icon">
                                    <img class="left" src="assets/front/images/left-info-box.svg">
                                    <img class="right" src="assets/front/images/right-info-box.svg">
                                    <img data-lazyloaded="1" src="assets/front/images/suitcase-portfolio-1.svg" decoding="async"
                                         data-src="assets/front/images/book-1.svg" alt="">
                                </div>
                                <div class="title">
                                </div>
                                <div class="description">
                                    <p>همراهی دانشجویان از سطح مبتدی تا تسلط به بازارکار</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rose-icon-box-wrapper btn btn-4">
                                <div class="icon">
                                    <img class="left" src="assets/front/images/left-info-box.svg">
                                    <img class="right" src="assets/front/images/right-info-box.svg">
                                    <img data-lazyloaded="1" src="assets/front/images/Medal-Prize-Reward-1.svg" decoding="async"
                                         data-src="assets/front/images/book-1.svg" alt="">
                                </div>
                                <div class="title">
                                </div>
                                <div class="description">
                                    <p>تحلیل و مشاوره در بستری غنی از تجربه، اعتبار و آگاهی</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rose-icon-box-wrapper btn btn-4">
                                <div class="icon">
                                    <img class="left" src="assets/front/images/left-info-box.svg">
                                    <img class="right" src="assets/front/images/right-info-box.svg">
                                    <img data-lazyloaded="1" src="assets/front/images/person-graduate.svg" decoding="async"
                                         data-src="assets/front/images/book-1.svg" alt="">
                                </div>
                                <div class="title">
                                </div>
                                <div class="description">
                                    <p>تعهد به رشد و توسعه‌ فردی و اجتماعی تمام دانشجویان</p>
                                </div>

                            </div>
                        </div>
                    </div>

                </section>
                <!--Info Boxes End-->
            </div>
        </div>
        <!--Hero section End-->

        <section class="rose-my bg-white dr-introduce">
            <div class="container">
                <div class="row g-5">
                    <div class="col-md-4 p-5">
                        <img src="assets/front/images/Dr-Photo-min.jpg" class="br-default " alt="دکتر بردیا خسروانی">
                    </div>
                    <div class="col-md-8 p-5">
                        <div class="d-flex flex-column justify-content-start align-items-start gap-4">
                            <h3 class="rose-sec-title">در یک ماموریت برای تغییر زندگی!</h3>
                            <p class="rose-default-p">
                                دکتر بردیا خسروانی مدرس، مشاور و نویسنده‌ای برجسته در حوزه مالی و روانشناسی و چهره‌ای شناخته شده
                                در
                                دنیای اقتصاد و آموزش ایران است. ایشان با سابقه‌ی درخشان در تدریس، مشاوره و تألیف آثار متعدد، به
                                عنوان
                                مرجعی قابل اعتماد و دلسوز در حوزه‌های مختلف مالی، به ویژه بازار بورس ایران، سرمایه‌گذاری و
                                مدیریت مالی و
                                روانشناسی مالی شناخته می‌شوند.
                            </p>
                            <a href="#" class="btn btn-lg btn-outline-dark line-height-0 py-3">
                                درباره دکتر خسروانی
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!--Products-->
        <section class="rose-my">
            <div class="container">
                <h2 class="rose-sec-title text-center mb-5">دوره ها</h2>

                <div class="owl-carousel owl-theme mt-5" data-owl-options='{
                            "nav": true,
                            "dots": false,
                            "margin": 20,
                            "rtl": true,
                            "loop": true,
                            "responsive": {
                                "0": {
                                    "items": 1
                                },
                                "480": {
                                    "items": 1
                                },
                                "576": {
                                    "items": 3
                                },
                                "768": {
                                    "items": 3
                                },
                                "992": {
                                    "items": 3
                                },
                                "1200": {
                                    "items": 3,
                                              "nav": true
                                }
                            }
                        }'>
                    @foreach(\Modules\Product\Models\Product::where('status', 'public')->orWhere('status', 'outofstock')->get() as $product)
                    <div class="item">
                        <div class="rose-product-card">
                            <div class="thumbnail">
                                <img src="{{ $product->image }}" alt="">
                            </div>
                            <div class="desc-wrapper">
                                <a class="h3" href="{{route('products.show' , $product)}}">
                                    {{$product->title}}
                                </a>
                                <p class="desc">{{ $product->short_description }}
                                </p>
                            </div>
                            <div class="badge-box">
                                <div class="rose-badge">
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.76958 2.28894C11.2517 2.70602 13.1446 4.85969 13.1446 7.46019C13.1446 10.3599 10.7943 12.7102 7.89458 12.7102C5.29408 12.7102 3.14041 10.8173 2.72333 8.33519"
                                              stroke="#737887" stroke-width="0.875" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M2.72262 6.58601C2.77804 6.25643 2.86379 5.93851 2.97754 5.63284"
                                              stroke="#737887"
                                              stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.54839 3.41544C4.29347 3.62602 4.05955 3.85994 3.84897 4.11485"
                                              stroke="#737887"
                                              stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.01954 2.28907C6.68996 2.34449 6.37146 2.43082 6.06638 2.54457"
                                              stroke="#737887"
                                              stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.16154 4.58325V7.728H5.60013" stroke="#737887" stroke-width="0.875"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>{{ $product->duration }}</p>
                                </div>
                            </div>
                            @if($product->is_free)
                                <p class="text-decoration-none fw-bold text-black">رایگان</p>
                            @else
                                @if($product->isOnSale())
                                    @php
                                        $discount_percent = (($product->price - $product->sale_price) / $product->price) * 100
                                    @endphp
                                    <div class="price-wrapper">
                                        <p class="price">
                                            {{number_format($product->price)}}
                                            تومان
                                        </p>
                                        <p class="sale-price">
                                            {{number_format($product->sale_price)}}
                                            تومان
                                        </p>

                                        <span class="discount-label">
                                                {{round($discount_percent )}} %
                                                تخفیف
                                            </span>
                                    </div>
                                @else
                                    <div class="price-wrapper">
                                        <p class="price text-decoration-none fw-bold text-black">
                                            {{number_format($product->price)}}
                                            تومان
                                        </p>
                                    </div>
                                @endif
                            @endif
                            <a href="{{ route('products.show', $product) }}" class="btn btn-default">ثبت نام</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </section>
        <!--Products End-->

        <!--testimonials-->
        <section class="rose-my bg-white">
            <div class="container rose-py">
                <h2 class="rose-sec-title text-center mb-5"> نظر دانشپذیران
                </h2>

                <div class="testimonials-wrapper row align-items-center position-relative ">
                    <svg class="comments-background" width="883" height="58" viewBox="0 0 883 58" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <line x1="883" y1="29" y2="29" stroke="#E7EAF2" stroke-width="2"/>
                        <g filter="url(#filter0_d_1762_33158)">
                            <circle cx="624" cy="29" r="4" fill="#0FABB5"/>
                        </g>
                        <circle cx="635" cy="29" r="3" fill="#87D1D7"/>
                        <g filter="url(#filter1_d_1762_33158)">
                            <circle cx="280" cy="29" r="4" transform="rotate(180 280 29)" fill="#0FABB5"/>
                        </g>
                        <circle cx="269" cy="29" r="3" transform="rotate(180 269 29)" fill="#87D1D7"/>
                        <defs>
                            <filter id="filter0_d_1762_33158" x="595" y="0" width="58" height="58" filterUnits="userSpaceOnUse"
                                    color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                               result="hardAlpha"/>
                                <feOffset/>
                                <feGaussianBlur stdDeviation="12.5"/>
                                <feComposite in2="hardAlpha" operator="out"/>
                                <feColorMatrix type="matrix"
                                               values="0 0 0 0 0.0588235 0 0 0 0 0.670588 0 0 0 0 0.709804 0 0 0 1 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1762_33158"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1762_33158" result="shape"/>
                            </filter>
                            <filter id="filter1_d_1762_33158" x="251" y="0" width="58" height="58" filterUnits="userSpaceOnUse"
                                    color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                               result="hardAlpha"/>
                                <feOffset/>
                                <feGaussianBlur stdDeviation="12.5"/>
                                <feComposite in2="hardAlpha" operator="out"/>
                                <feColorMatrix type="matrix"
                                               values="0 0 0 0 0.0588235 0 0 0 0 0.670588 0 0 0 0 0.709804 0 0 0 1 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1762_33158"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1762_33158" result="shape"/>
                            </filter>
                        </defs>
                    </svg>
                    <div class="testimonials-carousel owl-carousel" data-owl-options='{
                            "nav": true,
                            "center":true,
                            "dots": false,
                            "margin": 20,
                            "rtl": true,
                            "loop": true,
                            "responsive": {
                                "0": {
                                    "items": 1
                                },
                                "480": {
                                    "items": 1
                                },
                                "576": {
                                    "items": 3
                                },
                                "768": {
                                    "items": 3
                                },
                                "992": {
                                    "items": 3
                                },
                                "1200": {
                                    "items": 3,
                                              "nav": true
                                }
                            }
                        }'>
                        <div class="item">
                            <div class="testimonial-item">
                                <div class="testimonial-inner">
                                    <!--testimonials avatar -->
                                    <div class="testimonial-author">
                                        <div class="testimonial-avatar">
                                            <img src="assets/front/images/testimonials.jpg">
                                        </div>
                                    </div>
                                    <!--testimonials avatar end -->

                                    <div class="testimonial-content-box">
                                        <div class="testimonial-author-main">

                                            <!--testimonials name -->
                                            <h5 class="testimonial-author-name">تست</h5>
                                            <!--testimonials name end -->

                                            <!--testimonials designation -->
                                            <span class="testimonial-author-role"></span>
                                            <!--testimonials designation end -->

                                        </div>

                                        <!--testimonials content -->
                                        <div class="testimonial-content">
                                            <blockquote>

                                                شما بهترین و بادانش ترین انسانی هستید که من تو زندگیم دیدم،
                                                به جرات میتونم بگم یکی از بهترین اتفاقات زندگیم اشنا شدن با شما و سبک معاملاتی
                                                شما و مهمتر از همه آشنا شدن با شیوه درست زندگی کردن و توصیه های برادرانه ای است
                                                که با ما به اشتراک میذارید.

                                                همیشه دعاگوی شما و عزیزانتون هستم، امیدوارم همواره خیر و خوبی و برکت تو زندگی
                                                تون جاری باشه
                                            </blockquote>
                                        </div>
                                        <!--testimonials content end -->
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-item">
                                <div class="testimonial-inner">
                                    <!--testimonials avatar -->
                                    <div class="testimonial-author">
                                        <div class="testimonial-avatar">
                                            <img src="assets/front/images/testimonials.jpg">
                                        </div>
                                    </div>
                                    <!--testimonials avatar end -->

                                    <div class="testimonial-content-box">
                                        <div class="testimonial-author-main">

                                            <!--testimonials name -->
                                            <h5 class="testimonial-author-name">تست</h5>
                                            <!--testimonials name end -->

                                            <!--testimonials designation -->
                                            <span class="testimonial-author-role"></span>
                                            <!--testimonials designation end -->

                                        </div>

                                        <!--testimonials content -->
                                        <div class="testimonial-content">
                                            <blockquote>

                                                شما بهترین و بادانش ترین انسانی هستید که من تو زندگیم دیدم،
                                                به جرات میتونم بگم یکی از بهترین اتفاقات زندگیم اشنا شدن با شما و سبک معاملاتی
                                                شما و مهمتر از همه آشنا شدن با شیوه درست زندگی کردن و توصیه های برادرانه ای است
                                                که با ما به اشتراک میذارید.

                                                همیشه دعاگوی شما و عزیزانتون هستم، امیدوارم همواره خیر و خوبی و برکت تو زندگی
                                                تون جاری باشه
                                            </blockquote>
                                        </div>
                                        <!--testimonials content end -->
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-item">
                                <div class="testimonial-inner">
                                    <!--testimonials avatar -->
                                    <div class="testimonial-author">
                                        <div class="testimonial-avatar">
                                            <img src="assets/front/images/testimonials.jpg">
                                        </div>
                                    </div>
                                    <!--testimonials avatar end -->

                                    <div class="testimonial-content-box">
                                        <div class="testimonial-author-main">

                                            <!--testimonials name -->
                                            <h5 class="testimonial-author-name">تست</h5>
                                            <!--testimonials name end -->

                                            <!--testimonials designation -->
                                            <span class="testimonial-author-role"></span>
                                            <!--testimonials designation end -->

                                        </div>

                                        <!--testimonials content -->
                                        <div class="testimonial-content">
                                            <blockquote>

                                                شما بهترین و بادانش ترین انسانی هستید که من تو زندگیم دیدم،
                                                به جرات میتونم بگم یکی از بهترین اتفاقات زندگیم اشنا شدن با شما و سبک معاملاتی
                                                شما و مهمتر از همه آشنا شدن با شیوه درست زندگی کردن و توصیه های برادرانه ای است
                                                که با ما به اشتراک میذارید.

                                                همیشه دعاگوی شما و عزیزانتون هستم، امیدوارم همواره خیر و خوبی و برکت تو زندگی
                                                تون جاری باشه
                                            </blockquote>
                                        </div>
                                        <!--testimonials content end -->
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-item">
                                <div class="testimonial-inner">
                                    <!--testimonials avatar -->
                                    <div class="testimonial-author">
                                        <div class="testimonial-avatar">
                                            <img src="assets/front/images/testimonials.jpg">
                                        </div>
                                    </div>
                                    <!--testimonials avatar end -->

                                    <div class="testimonial-content-box">
                                        <div class="testimonial-author-main">

                                            <!--testimonials name -->
                                            <h5 class="testimonial-author-name">تست</h5>
                                            <!--testimonials name end -->

                                            <!--testimonials designation -->
                                            <span class="testimonial-author-role"></span>
                                            <!--testimonials designation end -->

                                        </div>

                                        <!--testimonials content -->
                                        <div class="testimonial-content">
                                            <blockquote>

                                                شما بهترین و بادانش ترین انسانی هستید که من تو زندگیم دیدم،
                                                به جرات میتونم بگم یکی از بهترین اتفاقات زندگیم اشنا شدن با شما و سبک معاملاتی
                                                شما و مهمتر از همه آشنا شدن با شیوه درست زندگی کردن و توصیه های برادرانه ای است
                                                که با ما به اشتراک میذارید.

                                                همیشه دعاگوی شما و عزیزانتون هستم، امیدوارم همواره خیر و خوبی و برکت تو زندگی
                                                تون جاری باشه
                                            </blockquote>
                                        </div>
                                        <!--testimonials content end -->
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-item">
                                <div class="testimonial-inner">
                                    <!--testimonials avatar -->
                                    <div class="testimonial-author">
                                        <div class="testimonial-avatar">
                                            <img src="assets/front/images/testimonials.jpg">
                                        </div>
                                    </div>
                                    <!--testimonials avatar end -->

                                    <div class="testimonial-content-box">
                                        <div class="testimonial-author-main">

                                            <!--testimonials name -->
                                            <h5 class="testimonial-author-name">تست</h5>
                                            <!--testimonials name end -->

                                            <!--testimonials designation -->
                                            <span class="testimonial-author-role"></span>
                                            <!--testimonials designation end -->

                                        </div>

                                        <!--testimonials content -->
                                        <div class="testimonial-content">
                                            <blockquote>

                                                شما بهترین و بادانش ترین انسانی هستید که من تو زندگیم دیدم،
                                                به جرات میتونم بگم یکی از بهترین اتفاقات زندگیم اشنا شدن با شما و سبک معاملاتی
                                                شما و مهمتر از همه آشنا شدن با شیوه درست زندگی کردن و توصیه های برادرانه ای است
                                                که با ما به اشتراک میذارید.

                                                همیشه دعاگوی شما و عزیزانتون هستم، امیدوارم همواره خیر و خوبی و برکت تو زندگی
                                                تون جاری باشه
                                            </blockquote>
                                        </div>
                                        <!--testimonials content end -->
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <!--testimonials end-->

        <section>
            <div class="container">
                <div class="row">
                    <div class="d-flex flex-column align-items-center justify-content-center mb-5">
                        <h2 class="rose-sec-title text-center">گوشه کنار بازار های مالی</h2>
                        <p class="color-default fw-medium">با بینش ها و استراتژی‌های دکتر خسروانی شروع کنید</p>
                    </div>
                    <div class="col-md-6">
                        <div class="banner banner-default br-default" style="height: 300px">
                            <a href="{{ route('posts.index') }}">
                                <figure class="banner-img hover-scale">
                                    <img src="assets/front/images/blog.jpg" alt="">
                                    <figcaption class="banner-details position-absolute top-50 start-50 translate-middle">
                                        <h3 class="banner-title">
                                            وبلاگ
                                        </h3>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="banner banner-default br-default" style="height: 300px">
                            <a href="{{ route('podcasts.index') }}">
                                <figure class="banner-img hover-scale">
                                    <img src="assets/front/images/podcast.jpg" alt="">
                                    <figcaption class="banner-details position-absolute top-50 start-50 translate-middle">
                                        <h3 class="banner-title">
                                            پادکست
                                        </h3>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                </div>

                <h2 class="rose-sec-title text-center  rose-my"> سوالات متداول</h2>
                <div class="d-flex align-items-center justify-content-center">
                    <div class=" w-75">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item py-2 br-default">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        آیا دوره ها حضوری هستند؟
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        دوره ها به صورت مجازی و با فرمت ویدئو های ضبط شده در بستر اسپات پلیر هستند. این فایل ها
                                        بعد از ثبت نام بدون محدودیت زمانی در دسترس شما قرار خواهد گرفت.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item py-2 br-default">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        شرایط عضویت در کانال جامع چیست؟
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        کانال جامع “بررسی و تحلیل سهام” مخصوص دانش پذیران دوره “FIS” و “افزایش سرمایه” می‌باشد.
                                        چون سطح مطالب کانال بالا است و اگر آموزش ندیده باشید متوجه مطالب کانال نخواهید شد. جناب
                                        دکتر خسروانی به صورت روزانه در کانال فعالیت می‌کنند و همه‌ی سهم ها رو تحلیل می‌کنند.
                                        مشاوره مستقیم با خود جناب دکتر هست و شما می‌توانید طبق توصیه ها و راهنمایی های ایشون با
                                        آرامش سهم خرید و فروش کنید و از سرمایه گذاری در بازار بورس لذت ببرید.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item py-2 br-default">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        شرایط مشاوره با دکتر بردیا خسروانی چیست؟
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        جناب دکتر خسروانی مشاوره حضوری یا تلفنی ندارند به علت اینکه ایشان اعتقاد دارند پشتیبانی
                                        دوره ها باید بی نقص، دقیق و حرفه ای انجام شود، بنا بر این به شخصه پشتیبانی حدود 7000
                                        دانشپذیر را به عهده گرفتند و هر گونه مشاوره و راهنمایی به دانش‌پذیران‌شان می‌دهند. در
                                        صورتی که شما دانش‌پذیر هریک از دوره های مسیر ثروت ساز، افزایش سرمایه، fis و حسابدار نخبه
                                        باشید، می‌توانید با ایشان در هر زمینه مشورت کنید و سوالات خودتان را از ایشان بپرسید.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item py-2 br-default">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="headingFour">
                                        پرداخت اقساطی به چه صورت است؟
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        دوره ها با تخفیف ویژه لحاظ شده و شرایط ثبت نام برای همه ی عزیزان یکسان است. با عرض پوزش
                                        پرداخت اقساطی امکان پذیر نمی‌باشد چون قیمت ها کارشناسی شده است.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item py-2 br-default">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="headingSix">
                                        چگونه اسپات پلیر را نصب و لایسنس خود را وارد کنیم؟
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div id="79080916845">
                                            <script type="text/JavaScript"
                                                    src="https://www.aparat.com/embed/laenauw?data[rnddiv]=79080916845&data[responsive]=yes"></script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item py-2 br-default">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="headingSeven">
                                        برای مشاهده دوره‌ها محدودیت زمانی داریم؟
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        خیر؛ در هر زمان و مکان، شما با داشتن اینترنت فعال می‌توانید به دوره ها دسترسی داشته
                                        باشید.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
@endcomponent
