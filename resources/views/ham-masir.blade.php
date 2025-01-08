@component('front.master')
    @section('body_class')
        body-bg-ham-masir
    @endsection
    @section('content')
        <div class="main-sec ham-masir">
            <div class="ham-masir-hero position-relative">
                <video autoplay muted loop id="myVideo">
                    <source src="/assets/front/images/ham-masir.mp4" type="video/mp4">
                </video>
                <div class="ham-masir-part-1 text-center ">
                    <img src="/assets/front/images/هـم-_مــسیر.svg" alt="هم مسیر" width="250" height="auto">
                    <h3 class="text-white">دوستانتان را با خود هم‌مسیر کنید!</h3>
                    <p class="paragraph">با داشتن کد معرف، می‌توانید در دوره آموزشی مسیرثروت ساز با قیمتی مناسب شرکت
                        کرده و به
                        دانش و
                        مهارت‌های لازم برای موفقیت مالی دست پیدا کنید.
                    </p>

                    <div class="d-flex align-items-center gap-3 justify-content-center my-4 flex-wrap flex-lg-nowrap">
                        <a href="#" class="btn  bt-ham-masir br-4 ">ورود به رز کلاب</a>
                        <a href="#" class="btn  btn-outline-light br-4 " data-bs-target="#exampleModalToggle"
                           data-bs-toggle="modal">
                            <i class="bi bi-play line-height-0"></i>
                            مشاهده ویدیو توضیحات

                        </a>

                    </div>
                    <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                         aria-labelledby="exampleModalToggleLabel"
                         tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">توضیحات هم مسیر</h1>
                                </div>
                                <div class="modal-body">
                                    <video src="/assets/front/images/ham-masir-amoozesh.mp4" width="100%" controls
                                           class="my-5"></video>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container">
                <div class="row gx-5">
                    <div class="col-md-6 bg-ham-masir-grid d-flex align-items-center">
                        <div class=" d-flex flex-column gap-3">
                            <img src="/assets/front/images/ham-masir-title-1.svg" alt="هم مسیر" width="350">
                            <p style="text-align: justify;" class="color-p-ham-masir">دوره مسیر ثروت ساز که تلفیقی از
                                آموزش هوش
                                مالی، هدفگذاری و
                                آموزش طلا نقره میباشد، به سبب تغییراتی که در علم نوین روانشناسی مالی به وجود آمده است،
                                <span style="color: #ffffff;"><strong>بهروزرسانی</strong></span> شده است. <br>عزیزانی که
                                افتخار داشتیم قبلا در دوره مسیر ثروت ساز خدمت رسانی کردیم، میتوانند نسخه بهروزرسانی
                                شده این دوره را با <span style="color: #ffffff;"><strong>30% تخفیف</strong></span> بیشتر
                                تهیه
                                کنند.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="/assets/front/images/disc-ham-masir.png" alt="" class="py-5 py-lg-0">
                    </div>
                </div>
            </div>

            <div class="ham-masir-part-2">
                <div class="container">
                    <div class="row justify-content-center ">
                        <div class="rose-py-7 text-center ham-masir-gift">
                            <img src="/assets/front/images/gift-ham-masir.svg" alt="هم مسیر">
                            <h2 class="color-gold mt-5" style="font-size: 28px;">همچنین یک فرصت طلایی هم برایتان فراهم
                                کرده
                                ایم!</h2>

                            <p class="text-white">با معرفی دوره جدید مسیر ثروت ساز به دوستانتان، نه‌تنها به آن ها کمک
                                می‌کنید تا
                                به
                                اهداف مالی خود برسند و
                                با شما هم‌مسیر شوند، بلکه شما هم از مزایای بی‌نظیری بهره‌مند می‌شوید.

                            </p>
                        </div>
                        <div class="ham-masir-box-3 ham-masir-part-2-circle-bg">
                            <div class="d-flex gap-4 align-items-center justify-content-center flex-column flex-lg-row">
                                <div class="ham-masir-desc-box">
                                    <div class="head">
                                        <h3 class="m-0">رسالت مجموعه آموزشی رز</h3>
                                    </div>
                                    <div class="desc">
                                        <p class="text-justify">رسالت مجموعه آموزشی رز آموزش و ارتقا سطح مهارت و دانش
                                            افراد می
                                            باشد.
                                            طبق
                                            نظرسنجی‌ای که از
                                            دانش‌پذیران دوره مسیر ثروت ساز انجام داده‌ایم از مهم ترین دغدغه های آن ها
                                            کمک به
                                            عزیزان‌شان بوده است.
                                            شما میتوانید دوستانتان را با خود هم مسیر کنید و از هم مسیر کردن آن ها با
                                            خودتان در
                                            دوره
                                            مسیر ثروت ساز، امتیاز کسب کنید.</p>
                                    </div>
                                </div>
                                <div class="ham-masir-desc-box">
                                    <div class="head">
                                        <h3 class="m-0">هم مسیر</h3>
                                    </div>
                                    <div class="desc">
                                        <p class="text-justify">تمامی دانشپذیران دوره مسیر ثروت ساز یک “کد معرف” اختصاصی
                                            دارند
                                            که
                                            میتوانند از طریق ارسال کدمعرف به دوستان خود ، آن ها را به ثبت نام در دوره
                                            مسیر ثروت
                                            ساز
                                            دعوت کنند.
                                            با هر ثبت نام در سایت مجموعه که از طریق “کد معرف” شما انجام شود، می‌توانید
                                            از این
                                            امتیاز
                                            برای ثبت نام در دوره ها و استفاده از خدمات در سایت مجموعه آموزشی رز بهره‌مند
                                            شوید.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-4 align-items-center justify-content-center mt-4">
                                <div class="ham-masir-desc-box w-100 gold">
                                    <div class="head">
                                        <h3 class="m-0">تنها شما از این دعوت امتیاز کسب نمی‌کنید!</h3>
                                    </div>
                                    <div class="desc">
                                        <p class="text-justify">
                                            تمامی دانشپذیران دوره مسیر ثروت ساز یک “کد معرف” اختصاصی دارند که میتوانند
                                            از طریق
                                            ارسال
                                            کدمعرف به دوستان خود ، آن ها را به ثبت نام در دوره مسیر ثروت ساز دعوت کنند.
                                            با هر ثبت نام در سایت مجموعه که از طریق “کد معرف” شما انجام شود، می‌توانید
                                            از این
                                            امتیاز
                                            برای ثبت نام در دوره ها و استفاده از خدمات در سایت مجموعه آموزشی رز بهره‌مند
                                            شوید.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="/assets/front/images/notice.svg" alt="" class="my-4 d-none d-lg-block" width="1000">
                    </div>
                </div>
            </div>


            <div class="ham-masir-part-4">
                <div class="container">
                    <div class="row justify-content-center ">
                        <div class="ham-masir-box-3">
                            <div class="d-flex flex-column flex-lg-row gap-4">
                                <div
                                    class="d-flex gap-4 align-items-center justify-content-center flex-column flex-lg-row flex-grow-1">
                                    <div class="ham-masir-desc-box w-100">
                                        <div class="desc">
                                            <p style="text-align: justify;">هر یک ثبت نام در <strong><span
                                                        style="color: #ffffff;">سایت مجموعه آموزشی رز</span></strong> با
                                                کدمعرف شما
                                                (فقط 10بار قابل استفاده)</p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex gap-4 align-items-center justify-content-center flex-column flex-lg-row">
                                    <div class="ham-masir-desc-box gold w-100">
                                        <div class="desc">
                                            <p class="text-justify">500 امتیاز</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-lg-row gap-4 mt-4">
                                <div
                                    class="d-flex gap-4 align-items-center justify-content-center flex-column flex-lg-row flex-grow-1">
                                    <div class="ham-masir-desc-box w-100">
                                        <div class="desc">
                                            <p style="text-align: justify;">ثبت نام دوره <strong><span
                                                        style="color: #ffffff;">مسیر ثروت ساز</span></strong>
                                                با استفاده از کد معرف شما (فقط 10بار قابل استفاده)</p></div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex  gap-4 align-items-center justify-content-center flex-column flex-lg-row">
                                    <div class="ham-masir-desc-box gold w-100">
                                        <div class="desc">
                                            <p class="text-justify">2500 امتیاز</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-box border-y rose-my">
            <div class="container">
                <div class="row rose-py-7">
                    <div class="col-md-8">
                        <img src="/assets/front/images/نحوه-دریافت-تخفیف-و-جمع_آوری-امتیاز.svg" alt="" width="350">
                        <p class="mt-4 mb-4 color-p-ham-masir">
                            شما دانش‌پذیر عزیز دوره مسیر ثروت ساز، نه تنها می‌توانید از دعوت عزیزان‌تان امتیاز دریافت
                            کنید بلکه
                            هر موقع تصمیم به ثبت نام در نسخه جدید دوره مسیر ثروت ساز بگیرید، از مبلغ دوره به صورت
                            اتوماتیک 30%
                            کسر می‌گردد.
                        </p>
                        <p class="color-p-ham-masir">
                            برای دعوت از دوستان و جمع‌آوری امتیاز مراحل زیر را انجام دهید:
                        </p>

                        <ul class="p-0">
                            <li class="mt-4 d-flex gap-4 align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="45" viewBox="0 0 44 45"
                                     fill="none">
                                    <rect y="0.5" width="44" height="44" rx="5" fill="#F8B806"
                                          fill-opacity="0.08"></rect>
                                    <rect x="0.5" y="1" width="43" height="43" rx="4.5" stroke="white"
                                          stroke-opacity="0.2"></rect>
                                    <path
                                        d="M21.0873 21.78C21.0873 20.3427 21.014 19.1033 20.8673 18.062C20.7207 17.006 20.4273 15.7447 19.9873 14.278L22.1873 13.508C22.6567 14.9893 22.9647 16.2873 23.1113 17.402C23.2727 18.5167 23.3533 19.9687 23.3533 21.758V27.5H21.0873V21.78Z"
                                        fill="#F8B806"></path>
                                </svg>
                                <p class="color-p-ham-masir">کدمعرف: وارد پنل کاربری خود شوید و از بخش "رز کلاب" قسمت
                                    "هم‌مسیر"
                                    کد معرف خود را کپی کرده و
                                    برای دوستانتان ارسال نمایید.

                                </p>
                            </li>
                            <li class="mt-4 d-flex gap-4 align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="45" viewBox="0 0 44 45"
                                     fill="none">
                                    <rect y="0.5" width="44" height="44" rx="5" fill="#F8B806"
                                          fill-opacity="0.08"></rect>
                                    <rect x="0.5" y="1" width="43" height="43" rx="4.5" stroke="white"
                                          stroke-opacity="0.2"></rect>
                                    <path
                                        d="M22.55 20.988C21.8313 20.988 21.3327 20.834 21.054 20.526C21.0687 20.7607 21.076 21.1713 21.076 21.758V27.5H18.81V21.78C18.81 20.3427 18.7367 19.1033 18.59 18.062C18.4433 17.006 18.15 15.7447 17.71 14.278L19.888 13.508L20.878 17.358C21.098 18.194 21.5967 18.612 22.374 18.612C22.77 18.612 23.1073 18.4947 23.386 18.26C23.6647 18.0107 23.804 17.6953 23.804 17.314C23.804 16.8153 23.6573 15.708 23.364 13.992L25.652 13.508C25.9453 15.2533 26.092 16.544 26.092 17.38C26.092 18.0693 25.938 18.6927 25.63 19.25C25.322 19.7927 24.8967 20.218 24.354 20.526C23.826 20.834 23.2247 20.988 22.55 20.988Z"
                                        fill="#F8B806"></path>
                                </svg>
                                <p class="color-p-ham-masir">اشتراک گذاری کدمعرف: از دوستانتان بخواهید هنگام ثبت نام در
                                    سایت
                                    مجموعه، داخل بخش کد معرف آن
                                    را وارد کنند.
                                </p>
                            </li>
                        </ul>

                        <div
                            class="d-flex align-items-center gap-3 justify-content-start my-4 flex-wrap flex-lg-nowrap">
                            <a href="#" class="btn  bt-ham-masir br-4 ">ورود به رز کلاب</a>
                            <a href="#comments" class="btn  btn-outline-light br-4 ">
                                اشتراک گذاری کد معرف
                            </a>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="/assets/front/images/magnet-min.png" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="ham-masir-part-2">
            <div class="container">
                <div class="row justify-content-center ">
                    <div
                        class="rose-py-7 text-center ham-masir-part-2-circle-bg d-flex flex-column align-items-center justify-content-center">
                        <div class="ham-masir-gift w-ham-masir-70">
                            <h2 class="color-gold mt-5" style="font-size: 28px;">ثبت نام در دوره با 10 هزار تومان!
                                ایم!</h2>

                            <p class="color-p-ham-masir">اگر هر ده نفری که به ثبت نام در دوره مسیر ثروت ساز دعوت کرده&zwnj;اید
                                ثبت
                                نام خود را تکمیل کنند،
                                <span style="color: #ffffff;"><strong>30.000 امتیاز</strong></span> دریافت می&zwnj;کنید.
                            </p>
                            <p class="color-p-ham-masir">همچنین شما به دلیل این که قبلا در دوره مسیر ثروت ساز ثبت نام
                                کرده&zwnj;اید
                                <span
                                    style="color: #ffffff;"><strong>30% تخفیف</strong></span> به صورت اتوماتیک در هنگام
                                ثبت
                                نام
                                در
                                نسخه جدید این دوره، دریافت می&zwnj;کنید.</p>

                            <div class="ham-masir-desc-box mt-4">
                                <div class="desc">
                                    <p class="text-justify">با جمع‌آوری 30.000 امتیاز و 30% تخفیف ویژه دانش پذیران قبلی،
                                        شما
                                        می‌توانید این دوره را تنها با 10.000 تومان دریافت کنید!
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="row rose-py-7">
                            <div class="col-md-6">
                                <img src="/assets/front/images/guid-min.png" alt="">
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <img src="/assets/front/images/نحوه-تبدیل-امتیاز-کیف-پول.svg" alt="" width="250"
                                     class="my-3">
                                <p class="color-p-ham-masir" style="text-align: right">
                                    شما می‌توانید در بخش “تبدیل امتیاز به کیف پول” تعداد امتیاز مورد نظر خود را انتخاب
                                    کنید و
                                    دکمه “تبدیل” را بزنید. مبلغ به صورت خودکار به کیف پول شما اضافه می‌شود.
                                </p>

                                <img src="/assets/front/images/نحوه-استفاده-از-کیف-پول.svg" alt="" class="mt-5 mb-3"
                                     width="250">
                                <p class="color-p-ham-masir" style="text-align: right">
                                    هنگام ثبت نام در دوره ها و یا خدمات دیگر سایت، میتوانید با استفاده از زدن دکمه
                                    “استفاده از
                                    کیف پول”، از این مبلغ استفاده بفرمایید.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="glass-box shadow-none br-default p-5">
                <div class="row gx-5">
                    <div class="col-md-7 align-self-center">
                        <div class="product-short-details d-flex flex-column align-items-start gap-4">
                            <h1 class="text-white">مدیریت زندگی مالی (FLM)</h1>
                            <p class="short-desc color-p-ham-masir">
                                در دنیای پرشتاب و پیچیده بازارهای مالی، معامله&zwnj;گری صرفاً به دانش و علم مالی محدود
                                نمی&zwnj;شود،
                                قدرت
                                ذهن و هوش روانشناختی نقشی اساسی در کسب سود و پرهیز از ضرر و همچنین موفقیت …
                            </p>


                            <div
                                class="d-flex flex-wrap justify-content-center justify-content-lg-between w-100 align-items-center my-4 my-lg-0">
                                <!--Add To Cart Button-->
                                <a href="#" class="btn bt-ham-masir ">ثبت نام در دوره</a>
                                <!--Add To Cart Button End-->

                                <div class="product-price mt-4 mt-lg-0">
                                    <span class="discount-badge mb-3">28% تخفیف</span>
                                    <p class="old-price color-p-ham-masir">30.000.000
                                        <span class="prefix">تومان</span>
                                    </p>
                                    <p class="new-price color-p-ham-masir" style="color: #fff !important;">50.000.000
                                        <span class="prefix">تومان</span>
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="col-md-5">
                        <img src="/assets/front/images/fis.jpg" alt="" class="br-default shadow-none border-0">
                    </div>
                </div>
            </div>
            <div class="my-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="icon-box-inline glass-box justify-content-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"
                                 fill="none">
                                <path
                                    d="M44 17C44 24.18 38.18 30 31 30C30.66 30 30.3 29.98 29.96 29.96C29.46 23.62 24.38 18.54 18.04 18.04C18.02 17.7 18 17.34 18 17C18 9.82 23.82 4 31 4C38.18 4 44 9.82 44 17Z"
                                    fill="white"></path>
                                <path opacity="0.4"
                                      d="M30 31C30 38.18 24.18 44 17 44C9.82 44 4 38.18 4 31C4 23.82 9.82 18 17 18C17.34 18 17.7 18.02 18.04 18.04C24.38 18.54 29.46 23.62 29.96 29.96C29.98 30.3 30 30.66 30 31Z"
                                      fill="white"></path>
                                <path
                                    d="M15.24 29.24L17 26L18.76 29.24L22 31L18.76 32.76L17 36L15.24 32.76L12 31L15.24 29.24Z"
                                    fill="white"></path>
                            </svg>
                            <div class="content">
                                <h3 class="color-p-ham-masir">روانشاسی مالی</h3>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="icon-box-inline glass-box justify-content-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"
                                 fill="none">
                                <path
                                    d="M44 17C44 24.18 38.18 30 31 30C30.66 30 30.3 29.98 29.96 29.96C29.46 23.62 24.38 18.54 18.04 18.04C18.02 17.7 18 17.34 18 17C18 9.82 23.82 4 31 4C38.18 4 44 9.82 44 17Z"
                                    fill="white"></path>
                                <path opacity="0.4"
                                      d="M30 31C30 38.18 24.18 44 17 44C9.82 44 4 38.18 4 31C4 23.82 9.82 18 17 18C17.34 18 17.7 18.02 18.04 18.04C24.38 18.54 29.46 23.62 29.96 29.96C29.98 30.3 30 30.66 30 31Z"
                                      fill="white"></path>
                                <path
                                    d="M15.24 29.24L17 26L18.76 29.24L22 31L18.76 32.76L17 36L15.24 32.76L12 31L15.24 29.24Z"
                                    fill="white"></path>
                            </svg>
                            <div class="content">
                                <h3 class=" color-p-ham-masir">تقویت هوش مالی
                                </h3>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="icon-box-inline glass-box justify-content-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"
                                 fill="none">
                                <path
                                    d="M44 17C44 24.18 38.18 30 31 30C30.66 30 30.3 29.98 29.96 29.96C29.46 23.62 24.38 18.54 18.04 18.04C18.02 17.7 18 17.34 18 17C18 9.82 23.82 4 31 4C38.18 4 44 9.82 44 17Z"
                                    fill="white"></path>
                                <path opacity="0.4"
                                      d="M30 31C30 38.18 24.18 44 17 44C9.82 44 4 38.18 4 31C4 23.82 9.82 18 17 18C17.34 18 17.7 18.02 18.04 18.04C24.38 18.54 29.46 23.62 29.96 29.96C29.98 30.3 30 30.66 30 31Z"
                                      fill="white"></path>
                                <path
                                    d="M15.24 29.24L17 26L18.76 29.24L22 31L18.76 32.76L17 36L15.24 32.76L12 31L15.24 29.24Z"
                                    fill="white"></path>
                            </svg>
                            <div class="content">
                                <h3 class=" color-p-ham-masir">برنامه ریزی برای اهداف
                                </h3>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="icon-box-inline glass-box justify-content-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"
                                 fill="none">
                                <path
                                    d="M44 17C44 24.18 38.18 30 31 30C30.66 30 30.3 29.98 29.96 29.96C29.46 23.62 24.38 18.54 18.04 18.04C18.02 17.7 18 17.34 18 17C18 9.82 23.82 4 31 4C38.18 4 44 9.82 44 17Z"
                                    fill="white"></path>
                                <path opacity="0.4"
                                      d="M30 31C30 38.18 24.18 44 17 44C9.82 44 4 38.18 4 31C4 23.82 9.82 18 17 18C17.34 18 17.7 18.02 18.04 18.04C24.38 18.54 29.46 23.62 29.96 29.96C29.98 30.3 30 30.66 30 31Z"
                                      fill="white"></path>
                                <path
                                    d="M15.24 29.24L17 26L18.76 29.24L22 31L18.76 32.76L17 36L15.24 32.76L12 31L15.24 29.24Z"
                                    fill="white"></path>
                            </svg>
                            <div class="content">
                                <h3 class=" color-p-ham-masir">مباحث روانشناسی
                                </h3>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row rose-py-7">
                <div class="col-md-3">
                    <div class="glass-box p-3 br-default shadow-none">
                        <video src="/assets/front/images/ham-masir1.mp4" width="100%" class="br-default shadow-none"
                               controls></video>
                        <h3 class="text-white mt-4">دوره مسیر ثروت ساز</h3>
                        <span class="badge bg-light text-dark">دانشجوی دوره</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-box p-3 br-default shadow-none">
                        <video src="/assets/front/images/ham-masir2.mp4" width="100%" class="br-default shadow-none"
                               controls></video>
                        <h3 class="text-white mt-4">دوره مسیر ثروت ساز</h3>
                        <span class="badge bg-light text-dark">دانشجوی دوره</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-box p-3 br-default shadow-none">
                        <video src="/assets/front/images/ham-masir3.mp4" width="100%" class="br-default shadow-none"
                               controls></video>
                        <h3 class="text-white mt-4">دوره مسیر ثروت ساز</h3>
                        <span class="badge bg-light text-dark">دانشجوی دوره</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-box p-3 br-default shadow-none">
                        <video src="/assets/front/images/ham-masir4.mp4" width="100%" class="br-default shadow-none"
                               controls></video>
                        <h3 class="text-white mt-4">دوره مسیر ثروت ساز</h3>
                        <span class="badge bg-light text-dark">دانشجوی دوره</span>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endcomponent
