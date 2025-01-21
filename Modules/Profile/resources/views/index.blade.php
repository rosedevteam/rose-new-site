@extends("profile::layouts.main")

@section('content')
    <div class="panel-title-box d-flex align-items-center justify-content-between">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">حساب کاربری /</span> پیشخوان
        </h4>

        <div class="download-form">

        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">دوره های من</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2"> {{auth()->user()->orders()->where('status' , 'completed')->count()}}</h4>
                                <small class="text-success">دوره ثبت نام کرده اید</small>
                            </div>
                            <small>مجموع دوره ها</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                          <i class="bx bx-movie-play bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">کیف پول من</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">  {{auth()->user()->wallet->balance}}</h4>
                                <small class="text-success">تومان</small>
                            </div>
                            <small>مجموع موجودی کیف پول</small>
                        </div>
                        <span class="badge bg-label-warning rounded p-2">
                          <i class="bx bx-wallet bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">کانال جامع بررسی سهام</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2"> اشتراک فعالی ندارید</h4>
                                {{--                            <small class="text-success">تومان</small>--}}
                            </div>
                            <small>روز های باقی مانده اشتراک کانال شما</small>
                        </div>
                        <span class="badge bg-label-info rounded p-2">
                          <i class="bx bx-user-plus bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="secondary-font fw-medium">شاخص FIS</span>
                            <div class="d-flex align-items-baseline mt-2">
                                <h4 class="mb-0 me-2">غیر فعال</h4>
                                <small class="text-success">واحد</small>
                            </div>
                            <small>به زودی</small>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                          <i class="bx bx-line-chart bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-md-6 mb-4">
            <h6 class="text-white mt-3 ">آخرین مقالات وب سایت</h6>
            <div class="swiper" id="blog-posts-carousel">
                <div class="swiper-wrapper">


                    @foreach(\Modules\Post\Models\Post::where('status' , 'public')->latest()->take(5)->get() as $post)
                        <div class="swiper-slide">
                            <div class="col-md">
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img class="card-img card-img-left" src="{{$post->image}}" alt="Card image">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <a href="{{route('posts.show' , $post)}}">
                                                    <h5 class="card-title mb-3">{{$post->title}}</h5>
                                                </a>
                                                <p class="card-text mb-n1"><small class="text-muted">
                                                        {{Verta::instance($post->created_at)->formatJalaliDate()}}
                                                    </small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <h6 class="text-white mt-3 ">تحلیل های دانشپذیران</h6>
            <div class="swiper" id="students-reports-carousel">
                <div class="swiper-wrapper">

                    @foreach(\Modules\StudentReport\Models\StudentReport::where('status' , 'approved')->latest()->take(5)->get() as $report)
                        <div class="swiper-slide">
                            <div class="col-md">
                                <div class="card mb-3">
                                    <div class="row g-0">

                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title mb-3">{{$report->company}}</h5>
                                                <p class="card-text mb-n1"><small class="text-muted">
                                                        نویسنده:
                                                        {{$report->student->name()}}
                                                    </small></p>
                                                <p class="card-text mb-n1"><small class="text-muted">
                                                        تاریخ تحلیل:
                                                        {{$report->date}}
                                                    </small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                                            <a href="{{route('studentreport.show' , $report)}}" class="badge bg-label-success rounded p-2" download>
                                                <i class="bx bx-download bx-sm"></i>
                                                 دانلود
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    </div>

    <div class="row my-5">

        <div class="col-md-6 mb-4">
            <h6 class="text-white mt-3 ">گزارش روزانه بازار</h6>
            <div class="swiper" id="daily-reports-carousel">
                <div class="swiper-wrapper">

                    @foreach(\Modules\DailyReport\Models\DailyReport::latest(5)->get() as $dailyReport)
                        <div class="swiper-slide">
                            <div class="col-md">
                                <div class="card mb-3">
                                    <div class="row g-0">

                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title mb-3">
                                                    گزارش روزانه بازار
                                                </h5>
                                                <p class="card-text mb-n1"><small class="text-muted">
                                                        تاریخ گزارش:
                                                        {{$dailyReport->title}}
                                                    </small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                                            <a href="{{route('dailyreports.show' , $dailyReport)}}" class="badge bg-label-success rounded p-2" download>
                                                <i class="bx bx-download bx-sm"></i>
                                                دانلود
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    </div>

@endsection
