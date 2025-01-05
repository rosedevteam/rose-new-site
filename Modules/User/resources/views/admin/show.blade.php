@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
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
                                    <div class="user-info text-center bg-">
                                        <h5 class="mb-2">{{ $user->first_name . ' ' . $user->last_name }}</h5>
                                        @foreach($user->getRoleNames() as $role)
                                            <span @class(['badge', 'bg-primary' => $role == 'مشتری', 'bg-reddit' => $role == 'ادمین', 'bg-info' => $role == 'نویسنده', 'bg-instagram' => $role == 'پشتیبان', 'bg-success' => $role == 'super-admin'])>{{ $role }}</span>
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
                                    @if($canEdit)
                                        <a href="javascript:;" class="btn btn-primary me-3"
                                           data-bs-target="#editUser"
                                           data-bs-toggle="modal">ویرایش</a>
                                    @endif
                                    @if($canDelete)
                                        <a href="javascript:;" class="btn btn-label-danger me-3 suspend-user"
                                           data-bs-target="#deleteUser" data-bs-toggle="modal">حذف کاربر</a>
                                        @endif
                                    @if($canSetRole)
                                        <a href="javascript:;" class="btn btn-label-slack"
                                           data-bs-target="#setRole" data-bs-toggle="modal">ویرایش نقش</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!is_null($orders) && !$orders->isEmpty())
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
                                                colspan="1" style="width: 15%;">وضعیت
                                            </th>
                                            <th class="sorting sorting_desc" tabindex="0"
                                                aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" style="width: 15%;">روش
                                                پرداخت
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1"
                                                colspan="1" style="width: 15%;">قیمت خرید
                                            </th>
                                            <th class="control sorting dtr-hidden" tabindex="0"
                                                aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                                style="width: 15%;">تاریخ سفارش
                                            </th>
                                            <th class="control sorting dtr-hidden" tabindex="0"
                                                aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                                style="width: 15%;">ویرایش
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
                                                        <a href="{{ route('admin.products.edit', $product) }}"
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
                                                <td>
                                                    <div class="d-flex gap-3 text-nowrap">
                                                        <a href="{{ route('admin.orders.edit', $order) }}"
                                                           class="btn btn-sm btn-info">
                                                            ویرایش
                                                        </a>
                                                    </div>
                                                </td>
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

            @if($canEdit)
                <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
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
                                               class="form-control" value="{{ $user->first_name }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="last_name">نام خانوادگی</label>
                                        <input type="text" id="last_name" name="last_name"
                                               class="form-control" value="{{ $user->last_name }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="email">ایمیل</label>
                                        <input type="text" id="email" name="email"
                                               class="form-control text-start" value="{{ $user->email }}"
                                               dir="ltr">
                                    </div>
                                    @can('edit-billings')
                                        @if(!is_null($billing))
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="address">آدرس</label>
                                                <input type="text" id="address" name="address"
                                                       class="form-control text-start"
                                                       value="{{ $billing->address }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="city">شهر</label>
                                                <input type="text" id="city" name="city"
                                                       class="form-control text-start"
                                                       value="{{ $billing->city }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="province">استان</label>
                                                <input type="text" id="province" name="province"
                                                       class="form-control text-start"
                                                       value="{{ $billing->province }}">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="postal_code">کد پستی</label>
                                                <input type="text" id="postal_code" name="postal_code"
                                                       class="form-control text-start"
                                                       value="{{ $billing->postal_code }}">
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
            @if($canDelete)
                <div class="modal fade" id="deleteUser" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
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
            @if($canSetRole)
                <div class="modal fade" id="setRole" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
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
                                            @if($role['name'] == 'super-admin')
                                                @continue
                                            @endif
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
        </div>
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
