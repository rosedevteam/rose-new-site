@extends("profile::layouts.main")

@section('content')

    <div class="ham-masir">
        @if(!auth()->user()->referal)
            <div class="alert alert-danger rose-danger mb-5" role="alert">
                <p>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M17 21.5H7C5.895 21.5 5 20.605 5 19.5V11.5C5 10.395 5.895 9.5 7 9.5H17C18.105 9.5 19 10.395 19 11.5V19.5C19 20.605 18.105 21.5 17 21.5Z"
                              stroke="#E92C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 17.59V15" stroke="#E92C56" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M12.5303 13.7197C12.8232 14.0126 12.8232 14.4874 12.5303 14.7803C12.2374 15.0732 11.7626 15.0732 11.4697 14.7803C11.1768 14.4874 11.1768 14.0126 11.4697 13.7197C11.7626 13.4268 12.2374 13.4268 12.5303 13.7197"
                              stroke="#E92C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 9.5V7.5V7.5C8 5.291 9.791 3.5 12 3.5V3.5C14.209 3.5 16 5.291 16 7.5V7.5V9.5"
                              stroke="#E92C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    امکان دعوت از دوستان و دریافت امتیاز بعد از خرید دوره
                    <strong>
                        <a href="https://roseoj.com/product/%d9%85%d8%b3%db%8c%d8%b1-%d8%ab%d8%b1%d9%88%d8%aa-%d8%b3%d8%a7%d8%b2-%d8%a8%d8%a7-%d8%a2%d9%85%d9%88%d8%b2%d8%b4-%d8%b7%d9%84%d8%a7-%d9%88-%d9%86%d9%82%d8%b1%d9%87/">
                            مسیر ثروت ساز
                        </a>
                    </strong>

                    به حساب کاربری شما اضافه خواهد شد
                </p>
            </div>
        @endif

        {{--        <div class="lock-screen"></div>--}}
        <div class="row">
            <div class="col-md-9">
                <div class="panel-title-box d-flex justify-content-between flex-column flex-sm-row align-items-sm-center">
                    <div class="mb-3 mb-sm-0">
                        <h3>دوستان خودت رو دعوت کن، تخفیف بگیر!</h3>
                        <h2>هم‌مســـیر</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="progress referral_persons_progress" style="direction: ltr;">
                    <div class="progress-bar" role="progressbar"
                         style="width: @if(auth()->user()->referal) {{auth()->user()->referal->referral_user->count() * 10}}@endif%"
                         aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="progress-details d-flex justify-content-between mt-2 ">
                    <div class="right">
                        <p class="m-0 fw-bold">تعداد افراد دعوت شده</p>
                        <p class="subtitle m-0">
                            @if(auth()->user()->referal)
                                {{10 - auth()->user()->referal->referral_user->count()}}
                            @else
                                0
                            @endif

                            ( دعوت باقی مانده)

                        </p>
                    </div>
                    <p>
                        @if(auth()->user()->referal)
                            {{auth()->user()->referal->referral_user->count()}}
                        @else
                            0
                        @endif
                        از
                        10
                        نفر
                    </p>
                </div>
            </div>


        </div>
        <div @if(!auth()->user()->referal) style="filter: grayscale(1)" @endif>
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class=" flex-lg-row d-flex align-items-center score-wrapper"
                         style="text-align: justify;">

                        <div class="rose-hammasir-guid flex-md-column d-md-flex">
                            <div class="guid-inner p-3">
                                <h3 class="title" style="color: #2A2A2A;">به دوستانت، موفقیت هدیه بده! </h3>
                                <p>با معرفی دوره مسیرثروت ساز به عزیزانتان و هم مسیر کردن آن ها در راه رسیدن به اهدافشان، امتیاز دریافت کنید.</p>

                                <div style=" color: #2A2A2A; font-size: 16px; font-weight: 800; line-height: 30px; word-wrap: break-word">
                                    نحوه عملکرد رز کلاب:
                                </div>
                                <div style="width: 100%;  color: #737887;  font-weight: 400; line-height: 27px; word-wrap: break-word">
                                    <p>
                                        تمامی دانشپذیران  دوره مسیر ثروت ساز یک  "کد معرف" اختصاصی دارند که میتوانند از طریق ارسال کدمعرف به دوستان خود ، آن ها را به ثبت نام در دوره مسیر ثروت ساز دعوت کنند.
                                    </p>
                                    <p>
                                        با هر ثبت نام در سایت مجموعه که از طریق "کد معرف" شما انجام شود، 500 امتیاز دریافت میکنید برای دریافت امتیاز بیشتر از دوستان خود دعوت کنید که در دوره مسیر ثروت ساز شرکت کنند تا  2500 امتیاز بیشتر دریافت کنید. توجه داشته باشید تعداد عزیزانی که میتوانند با کد معرف شما ثبت نام کنند، محدودیت 10 نفره دارد.
                                    </p>
                                    <p>
                                        شما میتوانید از این امتیاز برای ثبت نام در دوره ها و استفاده از خدمات درسایت مجموعه آموزشی رز بهره مند شوید.
                                    </p>
                                </div>


                                <div class="card my-5">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead>
                                            <tr class="text-nowrap">
                                                <th>روش های دریافت امیتاز</th>
                                                <th> میزان امتیاز</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            <tr>
                                                <td>ثبت نام در سایت از طریق کد معرف شما</td>
                                                <td>500</td>

                                            </tr>
                                            <tr>
                                                <td>ثبت نام دوره مسیر ثروت ساز با استفاده از کد معرف شما
                                                </td>
                                                <td>2500</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-3"
                                     style="width: 100%;  color: #2A2A2A; font-size: 16px;  font-weight: 700; line-height: 30px; word-wrap: break-word">
                                    تنها شما از این دعوت امتیاز کسب نمیکنید!
                                </div>
                                <div style="width: 100%;  color: #737887;  font-weight: 400; line-height: 27px; word-wrap: break-word">
                                    به فردی که توسط شما در دوره مسیر ثروت ساز شرکت کرده است، 20 درصد تخفیف ثبت نام در این دوره تعلق خواهد گرفت و به هم مسیران شما اضافه میشود.
                                </div>

                                <div class="mt-3">
                                    <div class="alert alert-info rose-info" role="alert">
                                        <strong>
                                            نکته مهم:
                                        </strong>
                                        در حال حاضر دریافت امتیاز فقط از طریق معرفی دوره مسیر ثروت ساز امکان پذیر میباشد.
                                    </div>
                                </div>

                                <div class="mt-3"
                                     style="width: 100%;  color: #2A2A2A; font-size: 16px;  font-weight: 700; line-height: 30px; word-wrap: break-word">
                                    نحوه دریافت امتیاز:
                                </div>

                                <ul class="mt-3">
                                    <li>
                                        وارد حساب کاربری خود در سایت مجموعه شوید، کد معرف خود را از منو، بخش "رز کلاب" کپی کرده و برای دوستانتان ارسال نمایید و از آنها بخواهید هنگام ثبت نام در سایت مجموعه، داخل بخش کد معرف آن را وارد کنند.
                                    </li>
                                    <li>
                                        به محض این که دوستانتان با کد شما ثبت نام کنند، امتیاز آن به صورت خودکار در بخش "امتیازمن" شما اضافه خواهد شد.
                                    </li>
                                </ul>

                                <div class="mt-3">
                                    <div class="alert alert-info rose-info" role="alert">
                                        <strong>
                                            توجه:
                                        </strong>
                                        محاسبه امتیاز فقط در صورتی که ثبت نام در سایت با "کد معرف" شما صورت بگیرد قابل انجام میباشد.
                                    </div>
                                </div>

                                <div class="mt-3"
                                     style="width: 100%;  color: #2A2A2A; font-size: 16px;  font-weight: 700; line-height: 30px; word-wrap: break-word">
                                    نحوه استفاده از امتیاز:
                                </div>

                                <div style="width: 100%;  color: #737887;  font-weight: 400; line-height: 27px; word-wrap: break-word">
                                    در بخش "تبدیل امتیاز به کیف پول" تعداد امتیاز مورد نظر خود را انتخاب کنید و دکمه "تبدیل" را بزنید. مبلغ به صورت خودکار به  کیف پول شما اضافه میشود.
                                </div>

                                <div class="mt-3"
                                     style="width: 100%;  color: #2A2A2A; font-size: 16px;  font-weight: 700; line-height: 30px; word-wrap: break-word">
                                    نحوه استفاده از کیف پول:
                                </div>

                                <div style="width: 100%;  color: #737887;  font-weight: 400; line-height: 27px; word-wrap: break-word">
                                    هنگام ثبت نام در دوره ها و یا خدمات دیگر سایت، میتوانید با استفاده از زدن دکمه "استفاده از کیف پول"، از این مبلغ استفاده بفرمایید.  </div>
                                <div id="masir-old-users"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="referral-code-box mt-3 mt-lg-0">
                        <div class="d-flex justify-content-center">
                            <img src="/assets/img/gift-2.svg" alt="">
                        </div>
                        <br>

                        <div class="d-flex justify-content-between mb-2">
                            <label for="referral" class="text-white" style="font-size: 16px;">کد معرف شما:</label>
                            <div class="d-flex gap-3">
                                <input name="referral" type="text" id="referral" style="font-size: 16px; flex: 1;background: transparent;border: none;padding: 0; font-weight:
                                600"
                                       class="form-control referral-code text-left text-white"
                                       placeholder="@if(auth()->user()->referal) {{auth()->user()->referal->code}}@endif"
                                       dir="ltr"
                                       value="@if(auth()->user()->referal){{auth()->user()->referal->code}}@endif">

                            </div>
                        </div>
                        <button class="btn btn-primary w-100 flex-0 rose-copy-referral-code-desc mb-2" style="flex: 0"
                                @if(auth()->user()->referal) onclick="copyToClipboardReferralDesc('{{auth()->user()->referal->code}}')" @endif>
                            <svg width="24" height="24" class="me-2" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect x="7" y="6.99805" width="14.0058" height="14.0058" rx="2" stroke="white"
                                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.99776 17.0024H4.99693C3.8919 17.0024 2.99609 16.1066 2.99609 15.0016V4.99742C2.99609 3.89239 3.8919 2.99658 4.99693 2.99658H15.0011C16.1061 2.99658 17.0019 3.89239 17.0019 4.99742V6.99825"
                                      stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            کپی متن دعوت
                        </button>
                        <button class="btn btn-primary w-100 flex-0 rose-copy-referral-code" style="flex: 0"
                                @if(auth()->user()->referal) onclick="copyToClipboardReferral('{{auth()->user()->referal->code}}')" @endif>
                            کپی کد
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="panel-title-box d-flex justify-content-between flex-column flex-sm-row align-items-sm-center mt-5">
        <div class="mb-3 mb-sm-0">
            <h3>دوستان خودت رو دعوت کن، تخفیف بگیر!</h3>
            <div class="d-flex align-items-center justify-content-between gap-2">
                <h2>تبدیل امتیاز به کیف پول</h2>

            </div>
        </div>
    </div>

    <div class="row mt-4 align-items-center" style=" --bs-gutter-x: 10rem;">
        <div class="col-md-5">
            <h6 class="m-0">راهنما</h6>
            <p style="text-align: justify;">
                شما میتوانید امتیازهای خود را به آسانی در این بخش نقد کرده وازآن در خدمات مجموعه آموزشی رز استفاده نمایید.
                توجه داشته باشید اگر میخواهید از این امتیاز در ثبت نام دوره و یا خدمات سایت استفاده کنید، حتما امتیاز را از این بخش به کیف پول تبدیل کنید.
            </p>
        </div>
        <div class="col-md-7">
            <div class="flex-wrap flex-column flex-lg-row d-flex align-items-center gap-3">

                <div class="score-exchange-wrapper" @if(!auth()->user()->referal) style="filter: grayscale(1)" @endif>
                    <div class="score-wrapper-box header">
                        <h3 class="mb-0">امتیاز من</h3>
                        <div class="my-score-wrapper d-flex">

                            <p class="score mb-0">
                                @php
                                    $credits = array_sum(auth()->user()->scores->where('type' , 'credit')->map(function ($score) {return $score->score;})->toArray());
$debits = array_sum(auth()->user()->scores->where('type' , 'debit')->map(function ($score) {return $score->score;})->toArray());
$score = $credits - $debits;
                                @endphp
                                {{number_format($score)}}

                            </p>
                            <div class="icon ms-2">
                                <img src="/assets/img/score.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="score-wrapper-box main">
                        <h3 class="mb-0"> تعداد</h3>
                        <div class="my-score-wrapper mb-0 d-flex">
                            <div class="input-group input-group-merge">
                                <input type="number" id="score-exchange" name="score"
                                       style="border: none; direction: ltr" step="500" min="0" max="{{$score}}"
                                       class="b-none form-control text-left numberstyle"
                                       placeholder="1000" value="0">
                                <span id="basic-icon-default-company2" style="border: none"
                                      class="input-group-text b-none">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<path d="M14 15.4014V21.1041C14.001 21.8774 15.5674 22.5045 17.501 22.5045C19.4345 22.5045 21.0009 21.8774 21.0019 21.1041V15.4014"
      stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14.0039 18.2524C14.0039 19.0257 15.5713 19.6528 17.5049 19.6528C19.4384 19.6528 21.0058 19.0257 21.0058 18.2524"
      stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 11.4997H7.00042" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 11.4997H11.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 14.5012H7.00042" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 14.5012H11.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 11.4997H7.00042" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 11.4997H11.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 17.5022H7.00042" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 17.5022H11.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 17.5022H7.00042" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 17.5022H11.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18.0023 8.49826H2.99609" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10.9994 20.5037H4.99693C3.8919 20.5037 2.99609 19.6079 2.99609 18.5028V5.49742C2.99609 4.39239 3.8919 3.49658 4.99693 3.49658H16.0015C17.1065 3.49658 18.0023 4.39239 18.0023 5.49742V11.4999"
      stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 11.4997H7.00042" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 11.4997H11.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14 11.4997H15.0004" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14.001 15.4014C14.001 16.1746 15.5684 16.8017 17.502 16.8017C19.4355 16.8017 21.0019 16.1746 21.0019 15.4014C21.0019 14.6271 19.4335 14.001 17.501 14.001C15.5684 14.001 14.001 14.6281 14 15.4014"
      stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="0.5" width="25" height="25" rx="12.5" stroke="#E7EAF2"/>
                    <path d="M16.0781 12.0948L18.2509 9.92275L16.0781 7.75" stroke="#0FABB5" stroke-width="1.125"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7.75 9.9248H18.25" stroke="#0FABB5" stroke-width="1.125" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M9.92275 13.9053L7.75 16.0773L9.92275 18.25" stroke="#0FABB5" stroke-width="1.125"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.25 16.0752H7.75" stroke="#0FABB5" stroke-width="1.125" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

                <div class="score-exchange-wrapper" @if(!auth()->user()->referal) style="filter: grayscale(1)" @endif>
                    <div class="score-wrapper-box header" id="rose-wallet">
                        <h3 class="mb-0">موجودی کیف پول</h3>
                        <div class="my-score-wrapper d-flex">

                            <p class="score mb-0 subtitle m-0">0</p>
                            <div class="icon ms-2">
                                <img src="/assets/img/wallet.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="score-wrapper-box main">
                        <h3 class="mb-0"> نرخ تبدیل</h3>
                        <div class="my-score-wrapper d-flex">
                            <div class="input-group input-group-merge align-items-center">
                                <p id="converted-price" class="m-0">0 تومان</p>
                                <span id="basic-icon-default-company2" style="border: none"
                                      class="input-group-text b-none">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd"
      d="M20 19.5H4C2.895 19.5 2 18.605 2 17.5V7.5C2 6.395 2.895 5.5 4 5.5H20C21.105 5.5 22 6.395 22 7.5V17.5C22 18.605 21.105 19.5 20 19.5Z"
      stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M13.7678 10.7322C14.7441 11.7085 14.7441 13.2915 13.7678 14.2678C12.7915 15.2441 11.2085 15.2441 10.2322 14.2678C9.25592 13.2915 9.25592 11.7085 10.2322 10.7322C11.2085 9.75592 12.7915 9.75592 13.7678 10.7322"
      stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 10V15" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18 10V15" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

                                    </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <button class="btn btn-primary w-100 flex-0 mt-3"  style="flex: 0; @if(!auth()->user()->referal) filter: grayscale(1); @endif" id="exchange-submit" disabled
                    onclick="exchangeScore()">تبدیل
            </button>
        </div>
    </div>

    <div class="panel-title-box d-flex justify-content-between flex-column flex-sm-row align-items-sm-center mt-5">
        <div class="mb-3 mb-sm-0">
            <h3>جزئیات استفاده از کد معرف</h3>
            <h2>هم مسیر های شما</h2>
        </div>
    </div>

    <div class="wallet-transactions score-logs">
        <div class="items">
            @foreach(auth()->user()->scores->sortByDesc('created_at') as $score)

                <div class="transaction-item @if($score->type == 'credit') credit @else debit @endif">
                    <div class="right">
                        <h3 class="title">{{$score->log}}</h3>
                    </div>
                    <div class="left d-flex align-items-center justify-content-between gap-2">
                        <h3 class="amount">
                            @if($score->type == 'credit')
                                {{$score->score}} +
                            @else
                                {{$score->score}} -
                            @endif
                        </h3>
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect y="0.5" width="24" height="24" fill="url(#pattern0_2838_43104)"/>
                            <defs>
                                <pattern id="pattern0_2838_43104" patternContentUnits="objectBoundingBox" width="1"
                                         height="1">
                                    <use xlink:href="#image0_2838_43104" transform="scale(0.00195312)"/>
                                </pattern>
                                <image id="image0_2838_43104" width="512" height="512"
                                       xlink:href="data:image/png;base64,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AADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAAAAPEQAAAPAQAQAAAA8RAAAA8BABAAAADxEAAADwEAEAxRdI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"/>
                            </defs>
                        </svg>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
@stop

@push('script')
    <script src="/assets/front/js/profile/scores.js"></script>
@endpush
