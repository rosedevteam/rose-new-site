@component('front.master')
    @section('content')
        <div class="main-sec top-bg second-bg ">
            <div class="container">
                <h2 class="rose-sec-title text-center mt-5 rose-py-7 pt-4">{{ $jobOffer->title }}</h2>
                <div class="row my-3 justify-content-around">
                    <div class="col">
                        <div class="fs-4 mb-3 description"><p>{{ $jobOffer->title }}</p></div>
                        <div class="d-flex align-items-center gap-3">
                            @foreach($jobOffer->categories as $category)
                                <p>{{ $category->name }}</p>
                            @endforeach
                            <p class="color-default">
                                {{ $jobOffer->type }}
                            </p>
                        </div>
                    </div>
                    <div class="col col-sm-2">
                        <button type="button" data-bs-target="#post-modal" class="btn btn-default btn-hero"
                                data-bs-toggle="modal">ارسال رزومه
                        </button>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="m-lg-5">
                        <div class="row fs-4 mb-5 description"><p>شرح موقعیت شغلی</p></div>
                        <div class="description"><p>{!! $jobOffer->content !!}</p></div>
                    </div>
                </div>
                <div class="row justify-content-between mt-4 mx-lg-1 gap-3">
                    <div class="card border-1 col-sm-3 justify-content-center">
                        <div class="row my-4">
                            <img src="/assets/front/images/point-direction-arrow.svg" alt="" width="46" height="46">
                            <p class="fw-bold">مسیر رشد</p>
                            <p>مسیر شغلی و رشد فردی در رز</p>
                        </div>
                    </div>
                    <div class="card border-1 col-sm-3 justify-content-start">
                        <div class="row my-4">
                            <img src="/assets/front/images/Group-User.svg" alt="" width="46" height="46">
                            <p class="fw-bold">مشارکت گروهی</p>
                            <p>ارتباط مداوم با کارشناسان</p>
                        </div>
                    </div>
                    <div class="card border-1 col-sm-3 justify-content-center">
                        <div class="row my-4">
                            <img src="/assets/front/images/Shapes-Objects.svg" alt="" width="46" height="46">
                            <p class="fw-bold">ساختار سازمانی</p>
                            <p>ساختار قدرتمند و یکپارچه</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="post-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        <form class="container"
                              action="{{ route('jobapplications.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row d-flex mt-3">
                                <label class="form-label" for="full_name">نام و نام خانوادگی</label>
                                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                                       class="form-control" required>
                            </div>
                            <div class="row d-flex mt-3 justify-content-between">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">ایمیل</label>
                                    <input type="text" id="email" name="email" value="{{ old('email') }}"
                                           class="form-control text-start" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">موبایل</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                           class="form-control text-start" required>
                                </div>
                            </div>
                            <div class="row d-flex mt-3">
                                <label class="form-label" for="resume">رزومه (pdf)</label>
                                <input id="resume" type="file" name="resume" value="{{ old('resume') }}"
                                       class="form-control" required>
                            </div>
                            <div class="row mt-3">
                                <label for="description" class="form-label">توضیحات</label>
                                <textarea id="description" name="description"
                                          class="form-control d-flex">{{ old('description') }}</textarea>
                                <input type="hidden" name="job_offer_id" value="{{ $jobOffer->id }}">
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-default btn-hero me-sm-3 me-1">ثبت</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    @endsection
@endcomponent
