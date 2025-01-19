@extends("profile::layouts.main")

@section('content')

    <div class="panel-title-box d-flex justify-content-between flex-column flex-sm-row align-items-sm-center">
        <div class="mb-3 mb-sm-0">
            <h3>مجموعه آموزشی رز</h3>
            <h2>دوره های من</h2>
        </div>

        <div class="d-flex align-items-center gap-3 flex-column-reverse flex-sm-row ">
            <a role="button" data-bs-toggle="modal" data-bs-target="#download-spotplayer" class="spotplayer-link">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5603 11.6106L12.0028 15.1681L8.44531 11.6106" stroke="#6611DE" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.0002 4.4967V15.1681" stroke="#6611DE" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path
                        d="M20.0028 16.9457C20.0028 18.9104 18.41 20.5032 16.4453 20.5032H7.55358C5.58883 20.5032 3.99609 18.9104 3.99609 16.9457"
                        stroke="#6611DE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                دانلود اسپات پلیر
            </a>
            <a href="#" class="btn btn-primary btn-lg spotplayer text-center">
                <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                     class="me-2">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M17 10.5209C17 14.2956 12.3552 17.0997 10.1401 18.2255C9.42545 18.5909 8.57896 18.5916 7.86365 18.2275C5.65012 17.1027 1 14.2918 1 10.5209V5.06936C1.00735 4.55851 1.39423 4.13322 1.9021 4.07768C4.02402 3.91644 6.05835 3.1641 7.7746 1.90592C8.50187 1.36467 9.49809 1.36467 10.2254 1.90592C11.9416 3.1641 13.9759 3.91644 16.0979 4.07768C16.6057 4.1332 16.9926 4.5585 17 5.06936V10.5209Z"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                راهنمای اسپات پلیر
            </a>

            {{-- Spot player versions modal --}}
            <div class="modal fade" id="download-spotplayer" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title secondary-font" id="modalCenterTitle">دانلود اسپات پلیر</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="card my-1 p-2 spotplayer-platform d-flex flex-column align-items-center justify-content-center">
                                        <img src="/assets/img/win.png" alt="نسخه ویندوز اسپات پلیر">
                                        <p class="card-subtitle">نسخه ویندوز</p>
                                        <a href="https://app.spotplayer.ir/assets/bin/spotplayer/setup.exe"
                                           class="btn btn-xs btn-primary" download>دانلود</a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="card my-1 p-2 spotplayer-platform d-flex flex-column align-items-center justify-content-center">
                                        <img src="/assets/img/mac.png" alt="نسخه مک اسپات پلیر">
                                        <p class="card-subtitle">نسخه MacOS</p>
                                        <a href="https://app.spotplayer.ir/assets/bin/spotplayer/setup.dmg"
                                           class="btn btn-xs btn-primary" download>دانلود</a>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="card my-1 p-2 spotplayer-platform d-flex flex-column align-items-center justify-content-center">
                                        <img src="/assets/img/android.png" alt="نسخه اندروید اسپات پلیر">
                                        <p class="card-subtitle">نسخه اندروید</p>
                                        <a href="https://app.spotplayer.ir/assets/bin/spotplayer/setup.apk"
                                           class="btn btn-xs btn-primary" download>دانلود</a>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="card my-1 p-2 spotplayer-platform d-flex flex-column align-items-center justify-content-center">
                                        <img src="/assets/img/web.png" alt="نسخه وب اسپات پلیر">
                                        <p class="card-subtitle">نسخه وب</p>
                                        <a href="https://app.spotplayer.ir/" class="btn btn-xs btn-primary" download>دانلود</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                بستن
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- !Spot player versions modal --}}

        </div>
    </div>


    {{--  Courses  --}}
    <div id="courses" class="row g-3">
        @if($products->count())
            @foreach($products as $product)
                <div class=" col-md-6 col-12">
                    <div class="course-holder flex-column flex-lg-row">
                        <div class="course-thumb">
                            <img src="{{$product->image}}" alt="">
                        </div>
                        <div class="details d-flex flex-grow-1 justify-content-around flex-column flex-lg-row">
                            <div class="d-flex flex-column w-100 flex-grow-1">
                                <h3 class="course-title-th">عنوان دوره</h3>
                                <p class="desc">{{$product->title}}</p>
                            </div>
                            <div class="d-flex flex-column w-100 flex-grow-1">

                                @if($product->is_free)
                                    <h3 class="course-title-th">مشاهده دوره</h3>
                                    <div class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                                        <a href="{{route('products.show' , $product)}}" class="btn btn-primary "
                                           target="_blank">
                                            مشاهده دوره
                                        </a>
                                    </div>

                                @else
                                    <h3 class="course-title-th">لایسنس اسپات پلیر</h3>
                                    <div class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                                        <input type="hidden" id="clipboard-{{$product->id}}"
                                               value="{{$product->spot_player_key}}">
                                        <button class="btn btn-primary "
                                                onclick="copyToClipboard($('#clipboard-{{$product->id}}'))">
                                            کپی لایسنس
                                        </button>
                                        @endif

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-danger rose-danger mb-5" role="alert">
                <p>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M17 21.5H7C5.895 21.5 5 20.605 5 19.5V11.5C5 10.395 5.895 9.5 7 9.5H17C18.105 9.5 19 10.395 19 11.5V19.5C19 20.605 18.105 21.5 17 21.5Z"
                              stroke="#E92C56" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M12 17.59V15" stroke="#E92C56" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path
                            d="M12.5303 13.7197C12.8232 14.0126 12.8232 14.4874 12.5303 14.7803C12.2374 15.0732 11.7626 15.0732 11.4697 14.7803C11.1768 14.4874 11.1768 14.0126 11.4697 13.7197C11.7626 13.4268 12.2374 13.4268 12.5303 13.7197"
                            stroke="#E92C56" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path
                            d="M8 9.5V7.5V7.5C8 5.291 9.791 3.5 12 3.5V3.5C14.209 3.5 16 5.291 16 7.5V7.5V9.5"
                            stroke="#E92C56" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    هنوز دوره ای ثبت نام نکرده اید
                </p>
            </div>

        @endif
    </div>
    {{--  Courses end  --}}

@stop
@push('script')
    <script src="/assets/front/js/profile/orders.js"></script>
@endpush
