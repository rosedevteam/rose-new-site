@extends('admin::layouts.main')

@section('title')
    کاربران
@endsection

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
                    <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0 primary-font">
                        <div class="col-md-4 user_role">
                            <select id="user_role" class="form-select text-capitalize">
                                <option value="" disabled selected hidden>انتخاب نقش</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                            </select></div>
                        <div class="col-md-4"><select id="sort_by" class="form-select text-capitalize">
                                <option value="" disabled selected hidden>ترتیب بر اساس</option>
                                <option value="first_name">نام</option>
                                <option value="last_name">نام خانوادگی</option>
                                <option value="created_at">تاریخ ثبت نام</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="sort_direction" class="form-select text-capitalize">
                                <option value="asc" selected>صعودی</option>
                                <option value="asc">نزولی</option>
                            </select>
                        </div>

                    </div>
                    <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0 primary-font">
                    <div class="col-md-4">
                        <div id="search" class="search-input"><label><input
                                    type="search" class="form-control" placeholder="جستجو ..."></label></div>
                    </div>
                </div>
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row mx-2">
                        <div class="col-md-20">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                @can('create-users')
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button class="btn btn-secondary add-new btn-primary ms-2" tabindex="0"
                                                aria-controls="DataTables_Table_0" type="button"
                                                data-bs-toggle="offcanvas"
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
                           id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                        <thead>
                        <tr>
                            <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="width: 25%" aria-sort="ascending">نام</th>
                            <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 15%;">نام
                                خانوادگی
                            </th>
                            <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 20%;">شماره
                                موبایل
                            </th>
                            <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 20%;" >ایمیل
                            </th>
                            <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                style="width: 20%;">نقش
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="odd">
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="last_name">نام خانوادگی</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">شماره موبایل</label>
                                    <input type="text" class="form-control" id="phone" name="phone" pattern="^[0-9]*$" maxlength="11" required>
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
{{--        <script src="/assets/admin/js/app-user-list.js"></script>--}}
@endpush
