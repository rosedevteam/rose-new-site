@extends('admin::layouts.main')


@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Users List Table -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-1 gap-md-0 primary-font">
                            <div class="col-md-3">
                                <label for="count" class="form-label">جستجو: </label>
                                <div id="search" class="search-input">
                                    <input type="search" name="search" value="{{ $search }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="role" class="form-label">نقش: </label>
                                <select id="role" name="role" class="form-select text-capitalize">
                                    <option value="" selected>همه نقش ها</option>
                                    @foreach($roles as $role)
                                        <option
                                            value="{{ $role['id'] }}" {{ $role_id == $role['id'] ? 'selected' : ''}}>{{ $role['name'] }}</option>
                                    @endforeach
                                </select></div>
                            <div class="col-md-2">
                                <label for="sort_by" class="form-label">ترتیب بر اساس: </label>
                                <select id="sort_by" name="sort_by" class="form-select text-capitalize">
                                    <option value="created_at" selected>تاریخ ثبت نام</option>
                                    <option value="first_name" {{ $sort_by == 'first_name' ? 'selected' : '' }}>نام
                                    </option>
                                    <option value="last_name" {{ $sort_by == 'last_name' ? 'selected' : '' }}>نام
                                        خانوادگی
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
                        @can('create-users')
                            <div class="row mx-2 my-2">
                                <div class="col-md-20">
                                    <div
                                        class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <button class="btn btn-secondary add-new btn-primary ms-2"
                                                    aria-controls="DataTables_Table_0" type="button"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasAddUser"><span><i
                                                        class="bx bx-plus me-0 me-lg-2"></i><span
                                                        class="d-none d-lg-inline-block">افزودن کاربر جدید</span></span>
                                            </button>
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
                                    colspan="1" style="width: 10%" aria-sort="ascending">نام
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">نام
                                    خانوادگی
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">شماره
                                    موبایل
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 15%;">ایمیل
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 7%;">نقش
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 12%;">تاریخ ثبت نام
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">جزییات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $user->first_name }}</span>
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
                                    <td>
                                        @foreach($user->getRoleNames() as $role)
                                            <span @class(['badge', 'bg-label-primary' => $role == 'مشتری', 'bg-label-reddit' => $role == 'ادمین', 'bg-label-info' => $role == 'نویسنده', 'bg-label-github' => $role == 'پشتیبان', 'bg-label-success' => $role == 'super-admin'])>{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ verta($user->created_at)->formatJalaliDateTime() }}</td>
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                               class="btn btn-sm btn-info">
                                                ویرایش
                                            </a>
                                            @can('delete', $user)
                                                <x-admin::deletebutton data-id="{{ $user->id }}"/>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>

                </div>
                <!-- Offcanvas to add new user -->
                @can('create-users')
                    <div class="offcanvas offcanvas-end" id="offcanvasAddUser"
                         aria-labelledby="offcanvasAddUserLabel">
                        <div class="offcanvas-header border-bottom">
                            <h6 id="offcanvasAddUserLabel" class="offcanvas-title">افزودن کاربر</h6>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body mx-0 flex-grow-0">
                            <form class="add-new-user pt-0" id="addNewUserForm"
                                  action="{{ route('admin.users.store') }}"
                                  method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">نام</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="last_name">نام خانوادگی</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">شماره موبایل</label>
                                    <input type="number" class="form-control" id="phone" name="phone" maxlength="11"
                                           required>
                                </div>
                                @can('promote-users')
                                    <div class="mb-3">
                                        <label class="form-label" for="role_id">نقش</label>
                                        <select id="role_id" class="form-select" name="role_id">
                                            @foreach($roles as $role)
                                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <select id="role_id" class="form-select" name="role_id" hidden>
                                            <option value="1"></option>
                                        </select>
                                    </div>
                                @endcan
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">ثبت</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">
                                    انصراف
                                </button>
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
    <x-admin::deletemodalscript model="users"/>
@endpush
