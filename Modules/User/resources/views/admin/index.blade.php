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
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row mx-2">
                        <div class="col-md-20">
                            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                <div class="me-2 me-md-3">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input
                                                    type="search" class="form-control" placeholder="جستجو ..."
                                                    aria-controls="DataTables_Table_0"></label></div>
                                </div>
                                @can('create-users')
                                <div class="dt-buttons btn-group flex-wrap">
                                    <button class="btn btn-secondary add-new btn-primary ms-2" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasAddUser"><span><i
                                                    class="bx bx-plus me-0 me-lg-2"></i><span
                                                    class="d-none d-lg-inline-block">افزودن کاربر جدید</span></span>
                                    </button>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <table class="datatables-users table border-top dataTable no-footer dtr-column"
                           id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1383px;">
                        <thead>
                        <tr>
                            <th class="control sorting_disabled dtr-hidden" rowspan="1" colspan="1"
                                style="width: 0px; display: none;" aria-label=""></th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="width: 156px;" aria-label="نام: فعال سازی نمایش به صورت نزولی"
                                aria-sort="ascending">نام
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 156px;" aria-label="نام خانوادگی: فعال سازی نمایش به صورت صعودی">نام
                                خانوادگی
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 119px;" aria-label="شماره موبایل: فعال سازی نمایش به صورت صعودی">شماره
                                موبایل
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 206px;" aria-label="ایمیل: فعال سازی نمایش به صورت صعودی">ایمیل
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 107px;" aria-label="نقش: فعال سازی نمایش به صورت صعودی">نقش
                            </th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 129px;"
                                aria-label="ویرایش">ویرایش
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="odd">
                                <td class="  control" tabindex="0" style="display: none;"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3"><img src="{{ $user->avatar }}"
                                                                                    class="rounded-circle" alt="avatar">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column"><a
                                                    href="{{ route('admin.user.show', $user->id) }}"
                                                    class="text-body text-truncate">
                                                <span class="fw-semibold">{{ $user->first_name }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                <span class="fw-semibold">
                                    {{ $user->last_name }}
                                </span>
                                </td>
                                <td><span class="fw-semibold">{{ $user->phone }}</span></td>
                                <td>{{ $user->email }}</td>
                                @php
                                    $role = $user->getRoleNames()[0]
                                @endphp
                                <td>
                                    <span @class(['badge', 'bg-label-primary' => $role == 'customer', 'bg-label-reddit'])>{{ $role }}</span>
                                </td>
                                <td>
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-sm btn-icon"><a
                                                    href="{{ route('admin.user.edit', $user->id) }}">
                                                <i class="bx bx-edit"></i></a></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    <div class="row mx-2">--}}
                    {{--                        <div class="col-sm-12 col-md-6">--}}
                    {{--                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">--}}
                    {{--                                نمایش 1 تا 10 از 50 ردیف--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-sm-12 col-md-6">--}}
                    {{--                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">--}}
                    {{--                                <ul class="pagination">--}}
                    {{--                                    <li class="paginate_button page-item previous disabled"--}}
                    {{--                                        id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0"--}}
                    {{--                                                                            data-dt-idx="previous" tabindex="0"--}}
                    {{--                                                                            class="page-link">قبلی</a></li>--}}
                    {{--                                    <li class="paginate_button page-item active"><a href="#"--}}
                    {{--                                                                                    aria-controls="DataTables_Table_0"--}}
                    {{--                                                                                    data-dt-idx="0" tabindex="0"--}}
                    {{--                                                                                    class="page-link">1</a></li>--}}
                    {{--                                    <li class="paginate_button page-item "><a href="#"--}}
                    {{--                                                                              aria-controls="DataTables_Table_0"--}}
                    {{--                                                                              data-dt-idx="1" tabindex="0"--}}
                    {{--                                                                              class="page-link">2</a></li>--}}
                    {{--                                    <li class="paginate_button page-item "><a href="#"--}}
                    {{--                                                                              aria-controls="DataTables_Table_0"--}}
                    {{--                                                                              data-dt-idx="2" tabindex="0"--}}
                    {{--                                                                              class="page-link">3</a></li>--}}
                    {{--                                    <li class="paginate_button page-item "><a href="#"--}}
                    {{--                                                                              aria-controls="DataTables_Table_0"--}}
                    {{--                                                                              data-dt-idx="3" tabindex="0"--}}
                    {{--                                                                              class="page-link">4</a></li>--}}
                    {{--                                    <li class="paginate_button page-item "><a href="#"--}}
                    {{--                                                                              aria-controls="DataTables_Table_0"--}}
                    {{--                                                                              data-dt-idx="4" tabindex="0"--}}
                    {{--                                                                              class="page-link">5</a></li>--}}
                    {{--                                    <li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#"--}}
                    {{--                                                                                                               aria-controls="DataTables_Table_0"--}}
                    {{--                                                                                                               data-dt-idx="next"--}}
                    {{--                                                                                                               tabindex="0"--}}
                    {{--                                                                                                               class="page-link">بعدی</a>--}}
                    {{--                                    </li>--}}
                    {{--                                </ul>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
                <!-- Offcanvas to add new user -->
                @can('create-users')
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
                                <label class="form-label" for="first_name">نام</label>
                                <input type="text" class="form-control" id="first_name" name="first_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="last_name">نام خانوادگی</label>
                                <input type="text" class="form-control" id="last_name" name="last_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">شماره موبایل</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="role_id">نقش کاربر</label>
                                <select id="role_id" name="role_id" class="form-select">
                                    @foreach($roles as $role)
                                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">ثبت</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">انصراف
                            </button>
                        </form>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
    {{ $users->links() }}
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
    {{--    <script src="/assets/admin/js/app-user-list.js"></script>--}}
@endpush
