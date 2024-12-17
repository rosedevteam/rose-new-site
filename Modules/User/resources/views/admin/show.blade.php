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
                                        <div class="avatar avatar-xl">
                                        <span class="avatar-initial rounded-circle bg-label-info fs-5">
                                            {{ substr($user->last_name, 0, 2) . ' ' . substr($user->first_name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="user-info text-center">
                                        <h5 class="mb-2">{{ $user->first_name . ' ' . $user->last_name }}</h5>
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
                                        <span class="fw-bold me-2">تماس:</span>
                                        <span class="d-inline-block">{{ $user->phone }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">ایمیل:</span>
                                        <span>{{ $user->email }}</span>
                                    </li>
                                    @can('view-billings')
                                        @if(!is_null($billing))
                                            <li class="mb-3">
                                                <span class="fw-bold me-2">آدرس:</span>
                                                <span class="d-inline-block">{{ $billing->address }}</span>
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-bold me-2">شهر:</span>
                                                <span class="d-inline-block">{{ $billing->city }}</span>
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-bold me-2">استان:</span>
                                                <span class="d-inline-block">{{ $billing->province }}</span>
                                            </li>
                                            <li class="mb-3">
                                                <span class="fw-bold me-2">کد پستی:</span>
                                                <span class="d-inline-block">{{ $billing->postal_code }}</span>
                                            </li>
                                        @endif
                                    @endcan
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">تاریخ ساخت اکانت:</span>
                                        <span
                                            class="d-inline-block">{{ verta($user->created_at)->formatJalaliDatetime() }}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-bold me-2">تاریخ آخرین آپدیت اکانت:</span>
                                        <span
                                            class="d-inline-block">{{ verta($user->updated_at)->formatJalaliDatetime() }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-3">
                                    @can('edit-users')
                                        @if(!$user->hasRole('ادمین'))
                                            <a href="javascript:;" class="btn btn-primary me-3"
                                               data-bs-target="#editUser"
                                               data-bs-toggle="modal">ویرایش</a>
                                        @endif
                                    @endcan
                                    @can('delete-users')
                                        @if(!$user->hasRole('ادمین') && auth()->user()->id != $user->id)
                                            <a href="javascript:;" class="btn btn-label-danger me-3 suspend-user"
                                               data-bs-target="#deleteUser" data-bs-toggle="modal">حذف کاربر</a>
                                        @endif
                                    @endcan
                                    @can('set-role')
                                        @if(auth()->user()->id != $user->id && !$user->hasRole('ادمین'))
                                            <a href="javascript:;" class="btn btn-label-slack"
                                               data-bs-target="#setRole" data-bs-toggle="modal">ویرایش نقش</a>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                </div>
                <!--/ User Sidebar -->

                @if(!is_null($orders))
                    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                        <div class="card mb-4">
                            <div class="card-header border-bottom">
                                <h5 class="card-title">سفارش ها</h5>
                            </div>
                            <div class="table-responsive mb-3">
                                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                    <table class="table datatable-invoice border-top dataTable no-footer dtr-column"
                                           id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info"
                                           style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th tabindex="0"
                                                aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                                style="width: 15%;">دوره ها
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1"
                                                colspan="1" style="width: 15%;"
                                                aria-label=": فعال سازی نمایش به صورت صعودی">وضعیت
                                            </th>
                                            <th class="sorting sorting_desc" tabindex="0"
                                                aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" style="width: 15%;"
                                                aria-label=": فعال سازی نمایش به صورت صعودی" aria-sort="descending">روش
                                                پرداخت
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1"
                                                colspan="1" style="width: 15%;"
                                                aria-label="جمع: فعال سازی نمایش به صورت صعودی">قیمت خرید
                                            </th>
                                            <th class="control sorting dtr-hidden" tabindex="0"
                                                aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                                style="width: 15%;"
                                                aria-label=": فعال سازی نمایش به صورت صعودی">تاریخ سفارش
                                            </th>
                                            <th class="control sorting dtr-hidden" tabindex="0"
                                                aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                                style="width: 15%;"
                                                aria-label=": فعال سازی نمایش به صورت صعودی">آخرین تغییر
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    @php
                                                        $len = count($order->products()->get())-1;
                                                        $i = 0
                                                    @endphp
                                                    @foreach($order->products()->get() as $product)
                                                        <a href="{{ route('admin.products.show', $product) }}"
                                                           class="text-body text-truncate"><span
                                                                class="fw-semibold">{{ $product->title . ($i != $len ? "، " : "") }}</span></a>
                                                        @php $i++ @endphp
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @switch($order->status)
                                                        @case('completed')کامل شده@break
                                                        @case('pending')در حال انجام@break
                                                        @case('returned')پس گرفته@break
                                                        @case('cancelled')لغو شده@break
                                                    @endswitch
                                                </td>
                                                <td>@switch($order->payment_method)
                                                        @case('shaparak') درگاه بانکی@break
                                                        @case('card')کارت به کارت@break
                                                    @endswitch</td>
                                                <td>{{ $order->price }}</td>
                                                <td>{{ verta($order->created_at)->formatJalaliDatetime() }}</td>
                                                <td>{{ verta($order->updated_at)->formatJalaliDatetime() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if(!is_null($logs))
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title">لاگ</h5>
                    </div>
                    <div class="table-responsive mb-3">

                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <table class="datatables-users table border-top dataTable no-footer dtr-column"
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
                                   style="width: 100%;">
                                <thead>
                                <tr>
                                    <th aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 12%" aria-sort="ascending">توضیحات
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 10%;">روی
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 10%;">تغییرات
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">تاریخ
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            <div
                                                class="d-flex justify-content-start align-items-center user-name">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $log->description }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <x-admin::logsubject :log="$log"/>
                                        <td>{{ $log->properties }}</td>
                                        <td>{{ verta($log->created_at)->formatJalaliDateTime() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Modal -->
            <!-- Edit User Modal -->
            @can('edit-users')
                @if(!$user->hasRole('ادمین'))
                    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    <div class="text-center mb-4 mt-0 mt-md-n2">
                                        <h3 class="secondary-font">ویرایش اطلاعات کاربر</h3>
                                    </div>
                                    <form id="editUserForm" class="row g-3"
                                          action="{{ route('admin.users.update', $user) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
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
                                                   class="form-control text-start" placeholder="{{ $user->email }}"
                                                   dir="ltr">
                                        </div>
                                        @can('edit-billings')
                                            @if(!is_null($billing))
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="address">آدرس</label>
                                                    <input type="text" id="address" name="address"
                                                           class="form-control text-start"
                                                           placeholder="{{ $billing->address }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="city">شهر</label>
                                                    <input type="text" id="city" name="city"
                                                           class="form-control text-start"
                                                           placeholder="{{ $billing->city }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="province">استان</label>
                                                    <input type="text" id="province" name="province"
                                                           class="form-control text-start"
                                                           placeholder="{{ $billing->province }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="postal_code">کد پستی</label>
                                                    <input type="text" id="postal_code" name="postal_code"
                                                           class="form-control text-start"
                                                           placeholder="{{ $billing->postal_code }}">
                                                </div>
                                            @endif
                                        @endcan
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
                @endif
            @endcan
            <!--/ Edit User Modal -->

            <!-- delete User modal -->
            @can('delete-users')
                @if(!$user->hasRole('ادمین') && auth()->user()->id != $user->id)
                    <div class="modal fade" id="deleteUser" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-simple">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center mb-4 mt-0 mt-md-n2">
                                        <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                                    </div>
                                    <form id="deleteUserForm" action="{{ route('admin.users.destroy', $user) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn btn-danger me-sm-3 me-1">حذف</button>
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
                @endif
            @endcan
            @can('set-role')
                @if(auth()->user() != $user && !$user->hasRole('admin'))
                    <div class="modal fade" id="setRole" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-simple">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center mb-4 mt-0 mt-md-n2">
                                        <h3 class="secondary-font">ویرایش نقش</h3>
                                    </div>
                                    <form id="deleteUserForm" action="{{ route('admin.users.role', $user) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role_id" class="form-select">
                                            @foreach($roles as $role)
                                                <option class="form-control"
                                                        value="{{ $role['id'] }}" {{ $role['name'] == $user->getRoleNames()[0] ? 'selected' : ""}}>{{ $role['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn btn-label-slack me-sm-3 me-1">ویرایش نقش
                                            </button>
                                            <button type="reset" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                انصراف
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endcan
            <!--/ delete User modal -->
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
