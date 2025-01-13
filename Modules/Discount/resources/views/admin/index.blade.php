@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.discounts.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-1 gap-md-0 primary-font">
                            <div class="col-md-3">
                                <label for="search" class="form-label">جستجو: </label>
                                <div id="search" class="search-input">
                                    <input type="search" name="search" value="{{ $search }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="is_active" class="form-label">وضعیت:</label>
                                <select id="is_active" name="is_active" class="form-select text-capitalize">
                                    <option value="all">همه</option>
                                    <option value="1" {{ $is_active == '1' ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ $is_active == '0' ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="type" class="form-label">نوع:</label>
                                <select id="type" name="type" class="form-select text-capitalize">
                                    <option value="all" selected>همه</option>
                                    <option value="amount" {{ $type == 'amount' ? 'selected' : '' }}>مقدار</option>
                                    <option value="percentage" {{ $type == 'percentage' ? 'selected' : '' }}>درصد
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sort_direction" class="form-label">نوع ترتیب: </label>
                                <select id="sort_direction" name="sort_direction" class="form-select text-capitalize">
                                    <option value="desc" selected>نزولی</option>
                                    <option value="asc" {{ $sort_direction == 'asc' ? 'selected' : '' }}>صعودی</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="count" class="form-label">تعداد: </label>
                                <select id="count" name="count" class="form-select text-capitalize">
                                    <option value="50" selected>50</option>
                                    <option value="100" {{ $count == "100" ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="submit" type="submit" class="btn btn-primary mt-4 data-submit">جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        @can('create-discounts')
                            <div class="row mx-2 my-2">
                                <div class="col-md-20">
                                    <div
                                        class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                        <div class="dt-buttons btn-group flex-wrap"><a
                                                href="{{ route('admin.discounts.create') }}">
                                                <button class="btn btn-secondary add-new btn-primary ms-2"
                                                        aria-controls="DataTables_Table_0" type="button"><span><i
                                                            class="bx bx-plus me-0 me-lg-2"></i><span
                                                            class="d-none d-lg-inline-block">ساخت تخفیف جدید</span></span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <table class="datatables-users table border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 10%" aria-sort="ascending">کد
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">نوع
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">مقدار
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">نویسنده
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 7%;">وضعیت
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 12%;">تاریخ انقضا
                                </th>
                                @can('edit-discounts')
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">عملیات
                                </th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>
                                <span class="fw-semibold">
                                        {{ $discount->code }}
                                </span>
                                    </td>
                                    <td>
                                <span class="fw-semibold">
                                    {{ $discount->type == 'amount' ? 'مقدار' : 'درصد' }}
                                </span>
                                    </td>
                                    <td><span
                                            class="fw-semibold">{{ $discount->amount }}@if($discount->type ==  'percentage')
                                                %
                                            @endif</span></td>
                                    <td>@can('view-users')
                                            <a href="{{ route('admin.users.edit', $discount->author) }}"
                                               class="text-body text-truncate">{{ $discount->author->name() }}</a>
                                        @else
                                            {{ $discount->author->name() }}
                                        @endcan</td>
                                    <td>@if($discount->is_active)
                                            <span class="badge bg-success">فعال</span>
                                        @else
                                            <span class="badge bg-danger">غیر فعال</span>
                                        @endif</td>
                                    <td>
                                        <span class=fw-semibold">
                                            {{ verta($discount->expires_at)->formatJalaliDatetime() }}
                                        </span>
                                    </td>
                                    @can('edit-users')
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            <a href="{{ route('admin.discounts.edit', $discount) }}"
                                               class="btn btn-sm btn-info">
                                                ویرایش
                                            </a>
                                            @can('delete-discounts')
                                                <x-admin::deletebutton data-id="{{ $discount->id }}"/>
                                            @endcan
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $discounts->links() }}
                    </div>

                </div>
                <!-- Offcanvas to add new user -->
                @can('create-users')
                    <div class="offcanvas offcanvas-end" id="offcanvasAddUser"
                         aria-labelledby="offcanvasAddUserLabel">
                        <div class="offcanvas-header border-bottom">
                            <h6 id="offcanvasAddUserLabel" class="offcanvas-title">ساخت تخفیف</h6>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body mx-0 flex-grow-0">
                            <form class="add-new-user pt-0" id="addNewUserForm"
                                  action="{{ route('admin.discounts.store') }}"
                                  method="POST">
                                @csrf

                            </form>
                        </div>
                    </div>
                @endcan
            </div>
            <x-admin::deletemodal/>
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
    <x-admin::deletemodalscript model="discounts"/>
@endpush
