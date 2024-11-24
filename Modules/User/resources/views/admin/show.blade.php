@extends('admin::layouts.main')

@section('title')
    مشاهده کاربر
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4">
                <span class="text-muted fw-light">کاربر / نمایش /</span> حساب
            </h4>
            <div class="row gy-4">
                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded my-4" src="{{ $user->avatar }}"
                                         height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h5 class="mb-2">{{ $user->last_name . ' ' . $user->first_name }}</h5>
                                        <span class="badge bg-label-secondary">{{ $user->getRoleNames()[0] }}</span>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-2 border-bottom mb-4 secondary-font">جزئیات</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">ایمیل:</span>
                                        <span>{{ $user->email }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">تماس:</span>
                                        <span class="d-inline-block" dir="ltr">{{ $user->phone }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">تاریخ ساخت اکانت:</span>
                                        <span class="d-inline-block" dir="ltr">{{ verta($user->created_at) }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">تاریخ آخرین آپدیت اکانت:</span>
                                        <span class="d-inline-block" dir="ltr">{{ verta($user->updated_at) }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-3">
                                    <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                                       data-bs-toggle="modal">ویرایش</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                </div>
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">


                <!-- Project table -->
                    <div class="card mb-4">
                        <div class="card-header"><h5 class="mb-0">لیست پروژه‌های کاربر</h5></div>
                        <div class="table-responsive mb-3">
                            <table class="table datatable-project border-top">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>پروژه</th>
                                    <th class="text-nowrap">مجموع وظیفه</th>
                                    <th>پیشرفت</th>
                                    <th>ساعت</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /Project table -->

                    <!-- Activity Timeline -->
                    <div class="card mb-4">
                        <div class="card-header mb-3"><h5 class="mb-0">خط زمانی فعالیت کاربر</h5></div>
                        <div class="card-body">
                            <ul class="timeline">
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-primary"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">12 صورتحساب پرداخت شد</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">12 دقیقه قبل</small>
                                        </div>
                                        <p class="mb-2">صورتحساب ها به شرکت پرداخت شد</p>
                                        <div class="d-flex">
                                            <a href="javascript:void(0)" class="me-3">
                                                <img src="../../assets/img/icons/misc/pdf.png" alt="PDF image"
                                                     width="20" class="me-2">
                                                <span class="fw-bold text-body">invoices.pdf</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-warning"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">ملاقات با مشتری</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">45 دقیقه قبل</small>
                                        </div>
                                        <p class="mb-2">ملاقات برای پروژه با استیو در 10:15 ق.ظ</p>
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div class="avatar me-3 mt-1">
                                                <img src="../../assets/img/avatars/3.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div>
                                                <h6 class="mb-1">بیل گیتس (مشتری)</h6>
                                                <span>بنیان‌گذار مایکروسافت</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-info"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">ایجاد یک پروژه جدید برای مشتری</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">2 روز قبل</small>
                                        </div>
                                        <p class="mb-2">5 عضو تیم در یک پروژه</p>
                                        <div class="d-flex align-items-center avatar-group">
                                            <div class="avatar pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="تونی استارک">
                                                <img src="../../assets/img/avatars/5.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top" title="بیل گیتس">
                                                <img src="../../assets/img/avatars/12.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top" title="پیتر پارکر">
                                                <img src="../../assets/img/avatars/9.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top" title="بروس وین">
                                                <img src="../../assets/img/avatars/6.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                            <div class="avatar pull-up" data-bs-toggle="tooltip"
                                                 data-popup="tooltip-custom" data-bs-placement="top"
                                                 title="اولیور کویین">
                                                <img src="../../assets/img/avatars/14.png" alt="آواتار"
                                                     class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point timeline-point-success"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0 mt-n1">بررسی طراحی</h6>
                                            <small class="text-muted mt-1 mt-sm-0 mb-1 mb-sm-0">5 روز قبل</small>
                                        </div>
                                        <p class="mb-0">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</p>
                                    </div>
                                </li>
                                <li class="timeline-end-indicator">
                                    <i class="bx bx-check-circle"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /Activity Timeline -->

                    <!-- Invoice table -->
                    <div class="card">
                        <div class="table-responsive mb-3">
                            <table class="table datatable-invoice border-top">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>شناسه</th>
                                    <th><i class="bx bx-trending-up"></i></th>
                                    <th>جمع</th>
                                    <th>تاریخ صدور</th>
                                    <th>عمل‌ها</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /Invoice table -->
                </div>
                <!--/ User Content -->
            </div>

            <!-- Modal -->
            <!-- Edit User Modal -->
            <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4 mt-0 mt-md-n2">
                                <h3 class="secondary-font">ویرایش اطلاعات کاربر</h3>
                                <p>به‌روزرسانی اطلاعات کاربر یک بررسی حریم خصوصی دریافت می کند.</p>
                            </div>
                            <form id="editUserForm" class="row g-3" onsubmit="return false">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserFirstName">نام</label>
                                    <input type="text" id="modalEditUserFirstName" name="modalEditUserFirstName"
                                           class="form-control" placeholder="جان">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserLastName">نام خانوادگی</label>
                                    <input type="text" id="modalEditUserLastName" name="modalEditUserLastName"
                                           class="form-control" placeholder="اسنو">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="modalEditUserName">نام کاربری</label>
                                    <input type="text" id="modalEditUserName" name="modalEditUserName"
                                           class="form-control text-start" placeholder="john.doe.007" dir="ltr">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserEmail">ایمیل</label>
                                    <input type="text" id="modalEditUserEmail" name="modalEditUserEmail"
                                           class="form-control text-start" placeholder="example@domain.com" dir="ltr">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserStatus">وضعیت</label>
                                    <select id="modalEditUserStatus" name="modalEditUserStatus" class="form-select"
                                            aria-label="Default select example">
                                        <option selected>وضعیت</option>
                                        <option value="1">فعال</option>
                                        <option value="2">غیرفعال</option>
                                        <option value="3">معلق</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditTaxID">شناسه مالیاتی</label>
                                    <input type="text" id="modalEditTaxID" name="modalEditTaxID"
                                           class="form-control modal-edit-tax-id" placeholder="123 456 7890">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserPhone">شماره تلفن</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="modalEditUserPhone" name="modalEditUserPhone"
                                               class="form-control phone-number-mask text-start"
                                               placeholder="202 555 0111" dir="ltr">
                                        <span class="input-group-text" dir="ltr">+98</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserLanguage">زبان</label>
                                    <select id="modalEditUserLanguage" name="modalEditUserLanguage"
                                            class="select2 form-select" multiple>
                                        <option value="">انتخاب</option>
                                        <option value="english" selected>انگلیسی</option>
                                        <option value="spanish">اسپانیایی</option>
                                        <option value="french">فرانسوی</option>
                                        <option value="german">آلمانی</option>
                                        <option value="dutch">هلندی</option>
                                        <option value="hebrew">عبری</option>
                                        <option value="sanskrit">سانسکریت</option>
                                        <option value="hindi">هندی</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserCountry">کشور</label>
                                    <select id="modalEditUserCountry" name="modalEditUserCountry"
                                            class="select2 form-select" data-allow-clear="true">
                                        <option value="">انتخاب</option>
                                        <option value="Australia">استرالیا</option>
                                        <option value="Bangladesh">بنگلادش</option>
                                        <option value="Belarus">بلاروس</option>
                                        <option value="Brazil">برزیل</option>
                                        <option value="Canada">کانادا</option>
                                        <option value="China">چین</option>
                                        <option value="France">فرانسه</option>
                                        <option value="Germany">آلمان</option>
                                        <option value="India">هندوستان</option>
                                        <option value="Indonesia">اندونزی</option>
                                        <option value="Israel">اسرائیل</option>
                                        <option value="Italy">ایتالیا</option>
                                        <option value="Japan">ژاپن</option>
                                        <option value="Korea">کره جنوبی</option>
                                        <option value="Mexico">مکزیک</option>
                                        <option value="Philippines">فیلیپین</option>
                                        <option value="Russia">روسیه</option>
                                        <option value="South Africa">آفریقای جنوبی</option>
                                        <option value="Thailand">تایلند</option>
                                        <option value="Turkey">ترکیه</option>
                                        <option value="Ukraine">اوکراین</option>
                                        <option value="United Arab Emirates">امارات</option>
                                        <option value="United Kingdom">انگلستان</option>
                                        <option value="United States">ایالات متحده</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input">
                                        <span class="switch-toggle-slider">
                              <span class="switch-on"></span>
                              <span class="switch-off"></span>
                            </span>
                                        <span class="switch-label">استفاده به عنوان آدرس صورتحساب؟</span>
                                    </label>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">ثبت</button>
                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        انصراف
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Edit User Modal -->

            <!-- Add New Credit Card Modal -->
            <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4 mt-0 mt-md-n2">
                                <h3 class="secondary-font">ارتقای پلن</h3>
                                <p>بهترین پلن برای کاربر را انتخاب کنید.</p>
                            </div>
                            <form id="upgradePlanForm" class="row g-3" onsubmit="return false">
                                <div class="col-sm-9">
                                    <label class="form-label" for="choosePlan">انتخاب پلن</label>
                                    <select id="choosePlan" name="choosePlan" class="form-select"
                                            aria-label="Choose Plan">
                                        <option selected>انتخاب پلن</option>
                                        <option value="standard">استاندارد - 99,000 تومان ماهانه</option>
                                        <option value="exclusive">اختصاصی - 249,000 تومان ماهانه</option>
                                        <option value="Enterprise">سازمانی - 499,000 تومان ماهانه</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">ارتقا</button>
                                </div>
                            </form>
                        </div>
                        <hr class="mx-md-n5 mx-n3">
                        <div class="modal-body">
                            <h6 class="mb-0">پلن کنونی کاربر پلن استاندارد است</h6>
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-md-n2">
                                <div class="d-flex justify-content-center align-items-center me-2 mt-2">
                                    <sup class="h5 pricing-currency fw-normal pt-2 mt-4 mb-0 me-1 text-primary">هزار
                                        تومان</sup>
                                    <h1 class="fw-normal display-1 mb-0 text-primary">99</h1>
                                    <sub class="h5 pricing-duration mt-auto mb-3">/ ماهانه</sub>
                                </div>
                                <button class="btn btn-label-danger cancel-subscription mt-3">لغو اشتراک</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Add New Credit Card Modal -->

            <!-- /Modal -->
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/moment/moment.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/admin/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/admin/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
@endpush

@push('script')
    <script src="/assets/admin/js/modal-edit-user.js"></script>
    <script src="/assets/admin/js/app-user-view.js"></script>
    <script src="/assets/admin/js/app-user-view-account.js"></script>
@endpush
