@extends('admin::layouts.main')

@section('title')
    مشاهده کاربر
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
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
                                    @if($user->avatar != null)
                                        <img class="img-fluid rounded my-4" src="{{ $user->avatar }}"
                                             height="110" width="110" alt="User avatar">
                                    @else
                                        <span class="avatar-initial rounded-circle bg-label-info align-content-center"
                                              style="width: 110px; height: 110px;">{{ substr($user->first_name, 0, 2) . ' ' . substr($user->last_name, 0, 2) }}</span>
                                    @endif
                                    <div class="user-info text-center">
                                        <h5 class="mb-2">{{ $user->last_name . ' ' . $user->first_name }}</h5>
                                        @foreach($user->getRoleNames() as $role)
                                            <span @class(['badge', 'bg-label-primary' => $role == 'مشتری', 'bg-label-reddit' => $role == 'ادمین', 'bg-label-info' => $role == 'نویسنده', 'bg-label-github' => $role == 'پشتیبان'])>{{ $role }}</span>
                                        @endforeach
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
                                    @can('delete-users')
                                        <a href="javascript:;" class="btn btn-label-danger suspend-user">حذف کاربر</a>
                                    @endcan
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
                            </div>
                            <form id="editUserForm" class="row g-3" action="{{ route('admin.user.update', $user) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="first_name">نام</label>
                                    <input type="text" id="first_name" name="first_name"
                                           class="form-control" placeholder="{{ $user->first_name }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="last_name">نام خانوادگی</label>
                                    <input type="text" id="last_name" name="last_name"
                                           class="form-control" placeholder="{{ $user->last_name }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="phone">شماره موبایل</label>
                                    <input type="text" id="phone" name="phone"
                                           class="form-control" placeholder="{{ $user->phone }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="email">ایمیل</label>
                                    <input type="text" id="email" name="email"
                                           class="form-control text-start" placeholder="{{ $user->email }}" dir="ltr">
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
    {{--    <script src="/assets/admin/js/modal-edit-user.js"></script>--}}
    <script src="/assets/admin/js/app-user-view.js"></script>
    <script src="/assets/admin/js/app-user-view-account.js"></script>
@endpush
