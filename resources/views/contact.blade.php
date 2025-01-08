@component('front.master')
    @section('content')

        <!--Hero section-->
        <div class="main-sec top-bg second-bg ">
            <div class="container ">
                <h2 class="rose-sec-title text-center mt-5 rose-py-7 pt-4">تماس با ما</h2>
                <h3 class="mt-4 ">ارتباط پیوسته با مجموعه آموزشی رز
                </h3>
                <p class="text-justify">
                    مجموعه آموزشی رز به صورت 24 ساعته در 7 روز هفته، پاسخگوی نیازها و پرسش‌های مشتریان و مخاطبان خود
                    است. شما
                    می‌توانید درخواست ها، گزارش ها و پیام‌هایتان را از طریق راه های ارتباطی درج شده در این صفحه، به دست
                    ما
                    برسانید.هدف ما در رز، توانمندسازی شما برای تصمیم‌گیری‌های آگاهانه و هوشمندانه در بازارهای پیچیده
                    مالی و کسب
                    سودآوری پایدار به همراه بازنشستگی زودهنگام و ایجاد درآمد غیرفعال است.
                </p>


                <!--iconboxes-->
                <div class="row my-5">
                    <div class="col-md-4">
                        <div class="icon-box-contact">
                            <img src="/assets/front/images/Messages-Chat.svg" alt="">

                            <div class="content p-3 mt-3 br-default text-center shadow-none">
                                <h3 class="title color-default">گفتگوی آنلاین</h3>
                                <p>
                                    تماس با کارشناسان ما از طریق چت آنلاین
                                </p>
                                <a href="#" class="btn btn-sm btn-default">ارتباط با پشتیبانی</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box-contact">
                            <img src="/assets/front/images/Group.svg" alt="">

                            <div class="content p-3 mt-3 br-default shadow-none text-center">
                                <h3 class="title color-default">تماس با کارشناسان</h3>
                                <p>
                                    ارتباط با کارشناسان ما از طریق تماس تلفنی
                                </p>
                                <a href="tel:02191691548" class="btn btn-sm btn-outline-secondary">021-91691548</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box-contact">
                            <img src="/assets/front/images/Mail-Email-Letter.svg" alt="">

                            <div class="content p-3 mt-3 br-default shadow-none text-center">
                                <h3 class="title color-default">ارسال ایمیل</h3>
                                <p>دریافت پیام های مکتوب شما از طریق ایمیل</p>
                                <p><a href="mailto:info@roseoj.com" class="color-default">info@roseoj.com</a></p>
                                <a href="mailto:info@roseoj.com" class="btn btn-sm btn-default">ارسال ایمیل</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!--iconboxes end-->
            </div>
        </div>
        <!--Hero section End-->

    @endsection
@endcomponent
