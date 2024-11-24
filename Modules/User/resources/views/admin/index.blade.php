@extends('admin::layouts.main')

@section('title')
    کاربران
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="secondary-font fw-medium">جلسه</span>
                                    <div class="d-flex align-items-baseline mt-2">
                                        <h4 class="mb-0 me-2">21,459</h4>
                                        <small class="text-success">(+29%)</small>
                                    </div>
                                    <small>مجموع کاربران</small>
                                </div>
                                <span class="badge bg-label-primary rounded p-2">
                          <i class="bx bx-user bx-sm"></i>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="secondary-font fw-medium">کاربران ویژه</span>
                                    <div class="d-flex align-items-baseline mt-2">
                                        <h4 class="mb-0 me-2">4,567</h4>
                                        <small class="text-success">(+18%)</small>
                                    </div>
                                    <small>تحلیل هفته اخیر </small>
                                </div>
                                <span class="badge bg-label-danger rounded p-2">
                          <i class="bx bx-user-plus bx-sm"></i>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="secondary-font fw-medium">کاربران فعال</span>
                                    <div class="d-flex align-items-baseline mt-2">
                                        <h4 class="mb-0 me-2">19,860</h4>
                                        <small class="text-danger">(-14%)</small>
                                    </div>
                                    <small>تحلیل هفته اخیر</small>
                                </div>
                                <span class="badge bg-label-success rounded p-2">
                          <i class="bx bx-group bx-sm"></i>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="secondary-font fw-medium">کاربران در انتظار</span>
                                    <div class="d-flex align-items-baseline mt-2">
                                        <h4 class="mb-0 me-2">237</h4>
                                        <small class="text-success">(+42%)</small>
                                    </div>
                                    <small>تحلیل هفته اخیر</small>
                                </div>
                                <span class="badge bg-label-warning rounded p-2">
                          <i class="bx bx-user-voice bx-sm"></i>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Users List Table -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0 primary-font">
                        <div class="col-md-4 user_role"></div>
                        <div class="col-md-4 user_plan"></div>
                        <div class="col-md-4 user_status"></div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-users table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th>کاربر</th>
                            <th>نقش</th>
                            <th>طرح</th>
                            <th>صورتحساب</th>
                            <th>وضعیت</th>
                            <th>عمل‌ها</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- Offcanvas to add new user -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
                     aria-labelledby="offcanvasAddUserLabel">
                    <div class="offcanvas-header border-bottom">
                        <h6 id="offcanvasAddUserLabel" class="offcanvas-title">افزودن کاربر</h6>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form class="add-new-user pt-0" id="addNewUserForm" action="{{ route('admin.user.store') }}"
                              method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="first-name">نام</label>
                                <input type="text" class="form-control" id="first-name" name="first-name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="last-name">نام خانوادگی</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">شماره موبایل</label>
                                <input type="text" class="form-control" id="last-name" name="last-name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">ایمیل</label>
                                <input type="text" id="email" class="form-control text-start" name="email" dir="ltr">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="user-role">نقش کاربر</label>
                                <select id="role" class="form-select">
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">ثبت</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">انصراف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/moment/moment.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="/assets/admin/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/admin/vendor/libs/cleavejs/cleave-phone.js"></script>
@endpush

@push('script')
    <script src="/assets/admin/js/app-user-list.js"></script>
@endpush
