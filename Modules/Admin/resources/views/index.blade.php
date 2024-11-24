@extends("admin::layouts.main")

@section('title')
    {{ "داشبورد" }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Website Analytics-->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">آمار وب‌سایت</h5>
                            <div class="dropdown primary-font">
                                <button class="btn p-0" type="button" id="analyticsOptions"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="analyticsOptions">
                                    <a class="dropdown-item" href="javascript:void(0);">انتخاب همه</a>
                                    <a class="dropdown-item" href="javascript:void(0);">تازه سازی</a>
                                    <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-2">
                            <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                                <div class="user-analytics text-center me-2">
                                    <i class="bx bx-user me-1"></i>
                                    <span>کاربران</span>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="chart-report" data-color="success" data-series="35"></div>
                                        <h3 class="mb-0">61K</h3>
                                    </div>
                                </div>
                                <div class="sessions-analytics text-center me-2">
                                    <i class="bx bx-pie-chart-alt me-1"></i>
                                    <span>جلسات</span>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="chart-report" data-color="warning" data-series="76"></div>
                                        <h3 class="mb-0">92K</h3>
                                    </div>
                                </div>
                                <div class="bounce-rate-analytics text-center">
                                    <i class="bx bx-trending-up me-1"></i>
                                    <span>نرخ نوسان</span>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="chart-report" data-color="danger" data-series="65"></div>
                                        <h3 class="mb-0">72.6%</h3>
                                    </div>
                                </div>
                            </div>
                            <div id="analyticsBarChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Referral, conversion, impression & income charts -->
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <!-- Referral Chart-->
                        <div class="col-sm-6 col-12 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h2 class="mb-1">32,690</h2>
                                    <span class="text-muted">ارجاع 40%</span>
                                    <div id="referralLineChart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Conversion Chart-->
                        <div class="col-sm-6 col-12 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between pb-3">
                                    <div class="conversion-title">
                                        <h5 class="card-title mb-1">تبدیل</h5>
                                        <p class="mb-0 text-muted primary-font">
                                            60%
                                            <i class="bx bx-chevron-up text-success"></i>
                                        </p>
                                    </div>
                                    <h2 class="mb-0 primary-font">89k</h2>
                                </div>
                                <div class="card-body">
                                    <div id="conversionBarchart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Impression Radial Chart-->
                        <div class="col-sm-6 col-12 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div id="impressionDonutChart" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Growth Chart-->
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar">
                                                                <span
                                                                    class="avatar-initial bg-label-primary rounded-circle"><i
                                                                        class="bx bx-user fs-4"></i></span>
                                                    </div>
                                                    <div class="card-info">
                                                        <h5 class="card-title mb-0 me-2 primary-font">
                                                            38,566</h5>
                                                        <small class="text-muted">تبدیل</small>
                                                    </div>
                                                </div>
                                                <div id="conversationChart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar">
                                                                <span
                                                                    class="avatar-initial bg-label-warning rounded-circle"><i
                                                                        class="bx bx-dollar fs-4"></i></span>
                                                    </div>
                                                    <div class="card-info">
                                                        <h5 class="card-title mb-0 me-2 primary-font">
                                                            53,659</h5>
                                                        <small class="text-muted">درآمد</small>
                                                    </div>
                                                </div>
                                                <div id="incomeChart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Referral, conversion, impression & income charts -->

                <!-- Activity -->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">فعالیت</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <li class="d-flex align-items-center mb-4 pb-2">
                                    <div class="avatar avatar-sm flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary"><i
                                                        class="bx bx-cube"></i></span>
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>کل فروش</span>
                                            <span class="text-muted">2,459</span>
                                        </div>
                                        <div class="progress" style="height: 6px">
                                            <div class="progress-bar bg-primary" style="width: 40%"
                                                 role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-4 pb-2">
                                    <div class="avatar avatar-sm flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded-circle bg-label-success"><i
                                                        class="bx bx-dollar"></i></span>
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>درآمد</span>
                                            <span class="text-muted">8,478</span>
                                        </div>
                                        <div class="progress" style="height: 6px">
                                            <div class="progress-bar bg-success" style="width: 80%"
                                                 role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-4 pb-2">
                                    <div class="avatar avatar-sm flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded-circle bg-label-warning"><i
                                                        class="bx bx-trending-up"></i></span>
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>بودجه</span>
                                            <span class="text-muted">12,490</span>
                                        </div>
                                        <div class="progress" style="height: 6px">
                                            <div class="progress-bar bg-warning" style="width: 80%"
                                                 role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <div class="avatar avatar-sm flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded-circle bg-label-danger"><i
                                                        class="bx bx-check"></i></span>
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>وظایف</span>
                                            <span class="text-muted">184</span>
                                        </div>
                                        <div class="progress" style="height: 6px">
                                            <div class="progress-bar bg-danger" style="width: 25%"
                                                 role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Activity -->

                <!-- Profit Report & Registration -->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-12 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-2">گزارش سود</h5>
                                </div>
                                <div class="card-body d-flex align-items-end justify-content-between">
                                    <div
                                        class="d-flex justify-content-between align-items-center gap-3 w-100 mb-1">
                                        <div class="d-flex align-content-center">
                                            <div class="chart-report mt-n1" data-color="danger"
                                                 data-series="25"></div>
                                            <div class="chart-info">
                                                <h5 class="mb-1 lh-inherit">12k تومان</h5>
                                                <small class="text-muted">1400</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-content-center">
                                            <div class="chart-report mt-n1" data-color="info"
                                                 data-series="50"></div>
                                            <div class="chart-info">
                                                <h5 class="mb-1 lh-inherit">64k تومان</h5>
                                                <small class="text-muted">1401</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 mb-4">
                            <div class="card h-100">
                                <div class="card-header pb-2">
                                    <h5 class="card-title mb-0">ثبت نام</h5>
                                </div>
                                <div class="card-body pb-2">
                                    <div class="d-flex justify-content-between align-items-end gap-3">
                                        <div class="mb-3">
                                            <div class="d-flex align-content-center align-items-center">
                                                <h5 class="mb-0">58.4k</h5>
                                                <i class="bx bx-chevron-up text-success"></i>
                                            </div>
                                            <small class="text-success">12.8%</small>
                                        </div>
                                        <div id="registrationsBarChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Profit Report & Registration -->

                <!-- Sales -->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-start justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2 mb-1">فروش‌ها</h5>
                                <small class="card-subtitle text-muted">محاسبه شده در 7 روز اخیر</small>
                            </div>
                            <div class="dropdown primary-font">
                                <button class="btn p-0" type="button" id="salesReport" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesReport">
                                    <a class="dropdown-item" href="javascript:void(0);">انتخاب همه</a>
                                    <a class="dropdown-item" href="javascript:void(0);">تازه سازی</a>
                                    <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="salesChart" class="mt-2"></div>
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-3">
                                            <span class="text-primary me-2 pt-1"><i
                                                    class="bx bx-up-arrow-alt bx-sm"></i></span>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">بیشترین فروش</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">شنبه</small>
                                        </div>
                                        <div class="item-progress">28.6k</div>
                                    </div>
                                </li>
                                <li class="d-flex">
                                            <span class="text-secondary me-2 pt-1"><i
                                                    class="bx bx-down-arrow-alt bx-sm"></i></span>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">کمترین فروش</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">پنجشنبه</small>
                                        </div>
                                        <div class="item-progress">7.9k</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Sales -->

                <!-- Growth Chart-->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="dropdown mb-3 mt-2">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButtonSec" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    1401
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"
                                     aria-labelledby="dropdownMenuButtonSec">
                                    <a class="dropdown-item" href="javascript:void(0);">1399</a>
                                    <a class="dropdown-item" href="javascript:void(0);">1400</a>
                                    <a class="dropdown-item" href="javascript:void(0);">1401</a>
                                </div>
                            </div>
                            <div id="growthRadialChart"></div>
                            <h6 class="mb-0">62% رشد در سال 1401</h6>
                        </div>
                    </div>
                </div>
                <!-- Growth Chart-->

                <!-- Finance Summary -->
                <div class="col-md-7 col-lg-7 mb-4 mb-md-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center me-3">
                                <img src="/assets/admin/img/avatars/4.png" alt="آواتار"
                                     class="rounded-circle me-3" width="54">
                                <div class="card-title mb-0">
                                    <h5 class="mb-0">گزارش مالی برای امیلیا کلارک</h5>
                                    <small class="text-muted primary-font">یک برنامه عالی برای مدیریت
                                        پروژه</small>
                                </div>
                            </div>
                            <div class="dropdown btn-pinned primary-font">
                                <button class="btn p-0" type="button" id="financoalReport"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="financoalReport">
                                    <a class="dropdown-item" href="javascript:void(0);">انتخاب همه</a>
                                    <a class="dropdown-item" href="javascript:void(0);">تازه سازی</a>
                                    <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-4 mb-5 mt-4">
                                <div class="d-flex flex-column me-2">
                                    <h6>تاریخ شروع</h6>
                                    <span class="badge bg-label-success">2 فروردین 1401</span>
                                </div>
                                <div class="d-flex flex-column me-2">
                                    <h6>تاریخ پایان</h6>
                                    <span class="badge bg-label-danger">6 اردیبهشت 1401</span>
                                </div>
                                <div class="d-flex flex-column me-2">
                                    <h6>اعضا</h6>
                                    <ul class="list-unstyled me-2 d-flex align-items-center avatar-group mb-0">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" title="تونی استارک"
                                            class="avatar avatar-xs pull-up">
                                            <img class="rounded-circle" src="/assets/admin/img/avatars/5.png"
                                                 alt="آواتار">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" title="استیو راجرز"
                                            class="avatar avatar-xs pull-up">
                                            <img class="rounded-circle" src="/assets/admin/img/avatars/12.png"
                                                 alt="آواتار">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" title="بری الن"
                                            class="avatar avatar-xs pull-up">
                                            <img class="rounded-circle" src="/assets/admin/img/avatars/6.png"
                                                 alt="آواتار">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" title="دیوید بکهام"
                                            class="avatar avatar-xs pull-up">
                                            <img class="rounded-circle" src="/assets/admin/img/avatars/14.png"
                                                 alt="آواتار">
                                        </li>
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" title="جسیکا آلبا"
                                            class="avatar avatar-xs pull-up">
                                            <img class="rounded-circle" src="/assets/admin/img/avatars/10.png"
                                                 alt="آواتار">
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-flex flex-column me-2">
                                    <h6>بودجه</h6>
                                    <span>249 میلیارد تومان</span>
                                </div>
                                <div class="d-flex flex-column me-2">
                                    <h6>هزینه‌ها</h6>
                                    <span>82k تومان</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                                <span class="text-nowrap lh-1-85 d-block mb-2">پیشرفت امیلیا کلارک</span>
                                <div class="progress w-100 mb-3" style="height: 8px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <span class="lh-1-85">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در</span>
                        </div>
                        <div class="card-footer border-top">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><i class="bx bx-check"></i> 74 وظیفه</li>
                                <li class="list-inline-item"><i class="bx bx-chat"></i> 678 دیدگاه</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Finance Summary -->

                <!-- Activity Timeline -->
                <div class="col-md-5 col-lg-5 mb-0">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0 me-2">خط زمانی فعالیت</h5>
                            <div class="dropdown primary-font">
                                <button class="btn p-0" type="button" id="timelineWapper"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
                                    <a class="dropdown-item" href="javascript:void(0);">انتخاب همه</a>
                                    <a class="dropdown-item" href="javascript:void(0);">تازه سازی</a>
                                    <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Activity Timeline -->
                            <ul class="timeline">
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-primary"></span>
                                    <div class="timeline-event pb-2">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">12 صورتحساب پرداخت شد</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">12 دقیقه
                                                قبل</small>
                                        </div>
                                        <p class="mb-2">صورتحساب ها به شرکت پرداخت شد</p>
                                        <div class="d-flex">
                                            <a href="javascript:void(0)" class="me-3">
                                                <img src="/assets/admin/img/icons/misc/pdf.png" alt="PDF image"
                                                     width="23" class="me-2">
                                                <span class="fw-bold text-body">invoices.pdf</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-warning"></span>
                                    <div class="timeline-event pb-2">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">ملاقات با مشتری</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">45 دقیقه
                                                قبل</small>
                                        </div>
                                        <p class="mb-2">ملاقات برای پروژه با استیو در 10:15 ق.ظ</p>
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div class="avatar me-3 mt-1">
                                                <img src="/assets/admin/img/avatars/1.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div>
                                                <h6 class="mb-1">بیل گیتس (مشتری)</h6>
                                                <span class="text-muted">بنیان‌گذار مایکروسافت</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent ps-4">
                                    <span class="timeline-point timeline-point-info"></span>
                                    <div class="timeline-event pb-0">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">ایجاد یک پروژه جدید برای مشتری</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">2 روز
                                                قبل</small>
                                        </div>
                                        <p class="mb-2">5 عضو تیم در یک پروژه</p>
                                        <div class="d-flex align-items-center avatar-group">
                                            <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="تونی استارک">
                                                <img src="/assets/admin/img/avatars/5.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="بیل گیتس">
                                                <img src="/assets/admin/img/avatars/12.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="پیتر پارکر">
                                                <img src="/assets/admin/img/avatars/9.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="بروس وین">
                                                <img src="/assets/admin/img/avatars/6.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar avatar-sm pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="اولیور کویین">
                                                <img src="/assets/admin/img/avatars/14.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-end-indicator">
                                    <i class="bx bx-check-circle"></i>
                                </li>
                            </ul>
                            <!-- /Activity Timeline -->
                        </div>
                    </div>
                </div>
                <!--/ Activity Timeline -->
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/apex-charts/apexcharts.js"></script>
@endpush

@push('script')
    <script src="/assets/admin/js/dashboards-analytics.js"></script>
@endpush
