@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
            <div class="flex-grow-1 mx-4">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row mx-2 my-2">
                            <div class="col-md-20">
                                <div
                                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                    <div class="dt-buttons btn-group flex-wrap">
                                        <button class="btn btn-secondary add-new btn-primary ms-2"
                                                aria-controls="DataTables_Table_0" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addRoleModal"><span><i
                                                    class="bx bx-plus me-0 me-lg-2"></i><span
                                                    class="d-none d-lg-inline-block">ساخت نقش جدید</span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="datatables-users table border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 1%" aria-sort="ascending">آیدی
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 10%" aria-sort="ascending">عنوان
                                </th>
{{--                                <th aria-controls="DataTables_Table_0" rowspan="1"--}}
{{--                                    colspan="1" style="width: 5%" aria-sort="ascending">تعداد کاربران--}}
{{--                                </th>--}}
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">جزییات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $role->name }}</span>
                                            </div>
                                        </div>
                                    </td>
{{--                                    <td>{{ $role->users->toArray() }}</td>--}}
                                    <td>
                                        @if($role->name != 'super-admin')
                                            <div class="d-flex gap-3 text-nowrap">
                                                <button class="btn btn-sm btn-info" data-bs-target="#editRoleModal"
                                                        data-bs-toggle="modal"
                                                        data-name="{{ $role->name }}"
                                                        data-permissions="{{ json_encode($role->permissions->pluck('name')->toArray()) }}"
                                                        data-route="{{ route('admin.roles.update', $role) }}"
                                                        id="edit-button">
                                                    ویرایش
                                                </button>
                                                <x-admin::deletebutton data-id="{{ $role->id }}"/>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-add-new-role">
                <div class="modal-content p-3 p-md-5">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="text-center mb-4 mt-0 mt-md-n2">
                            <h3 class="role-title secondary-font">افزودن نقش جدید</h3>
                            <p>مجوزهای نقش را تنظیم کنید</p>
                        </div>
                        <!-- Add role form -->
                        <form id="create-role" class="row g-3" action="{{ route('admin.roles.store') }}" method="POST">
                            @csrf
                            <div class="col-12 mb-4">
                                <label class="form-label" for="modalRoleName">نام نقش</label>
                                <input type="text" id="modalRoleName" name="roleName" class="form-control"
                                       placeholder="نام نقش را وارد کنید" tabindex="-1">
                            </div>
                            <div class="col-12">
                                <h5>مجوزهای نقش</h5>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                        <tr>
                                            <td class="text-nowrap">
                                                دسترسی پنل
                                            </td>
                                            <td>
                                                <div class="form-check me-3 me-lg-5 mb-0 mt-0">
                                                    <input class="form-check-input" name="permissions[]"
                                                           value="admin-panel" type="checkbox">
                                                    <label
                                                        class="form-check-label"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach($permissions as $key => $permission)
                                            <tr>
                                                <td class="text-nowrap">{{ translatePermission($key) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @foreach($permission as $p)
                                                            <div class="form-check me-3 me-lg-5 mb-0 mt-0">
                                                                <input class="form-check-input" name="permissions[]"
                                                                       value="{{ $p . '-' . $key }}" type="checkbox">
                                                                <label
                                                                    class="form-check-label">{{ translatePermission($p) }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
                            </div>
                            <div class="col-12 text-center">
                                <button form="create-role" type="submit" class="btn btn-primary me-sm-3 me-1">ثبت
                                </button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    انصراف
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-add-new-role">
                <div class="modal-content p-3 p-md-5">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="text-center mb-4 mt-0 mt-md-n2">
                            <h3 class="role-title secondary-font">ویرایش نقش</h3>
                            <p>مجوزهای نقش را تنظیم کنید</p>
                        </div>
                        <!-- Add role form -->
                        <form id="edit-role" class="row g-3" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="col-12 mb-4">
                                <label class="form-label" for="modalRoleName">نام نقش</label>
                                <input type="text" id="edit-roleName" name="edit-roleName" value=""
                                       class="form-control">
                            </div>
                            <div class="col-12">
                                <h5>مجوزهای نقش</h5>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                        <tr>
                                            <td class="text-nowrap">
                                                دسترسی پنل ادمین
                                            </td>
                                            <td>
                                                <div class="form-check me-3 me-lg-5 mb-0 mt-0">
                                                    <input class="form-check-input" name="edit-permissions[]"
                                                           value="admin-panel" type="checkbox">
                                                    <label
                                                        class="form-check-label"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach($permissions as $key => $permission)
                                            <tr>
                                                <td class="text-nowrap">{{ translatePermission($key) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @foreach($permission as $p)
                                                            <div class="form-check me-3 me-lg-5 mb-0 mt-0">
                                                                <input class="form-check-input"
                                                                       name="edit-permissions[]"
                                                                       value="{{ $p . '-' . $key }}" type="checkbox">
                                                                <label
                                                                    class="form-check-label">{{ translatePermission($p) }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
                            </div>
                            <div class="col-12 text-center">
                                <button form="edit-role" type="submit" class="btn btn-primary me-sm-3 me-1">ثبت
                                </button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    انصراف
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
            <x-admin::deletemodal/>
        <div class="content-backdrop fade"></div>
    </div>

@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/moment/moment.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <x-admin::deletemodalscript model="roles"/>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.addEventListener('click', (event) => {
                if (event.target.matches('#edit-button')) {
                    const name = event.target.getAttribute('data-name');
                    const permissions = JSON.parse(event.target.getAttribute('data-permissions'));
                    const route = event.target.getAttribute('data-route');
                    $('#edit-roleName').val(name);
                    $('#edit-role').attr('action', route);
                    $('input[name="edit-permissions[]"]').prop('checked', false);

                    Object.entries(permissions).forEach((i) => {
                        console.log(i)
                        $(`input[name="edit-permissions[]"][value="${i[1]}"]`).prop('checked', true);
                    })
                }
            });
        });
    </script>
@endpush

@php
    function translatePermission($permission)
    {
        switch($permission) {
            case 'view': $permission = 'مشاهده'; break;
            case 'edit': $permission = 'ویرایش'; break;
            case 'delete': $permission = 'حذف'; break;
            case 'create': $permission = 'ساخت'; break;
            case 'manage': $permission = 'مدیریت'; break;
            case 'assign': $permission = 'انتصاب'; break;
            case 'sendSMS': $permission = 'ارسال اس ام اس'; break;
            //
            case 'users': $permission = 'کاربران'; break;
            case 'billings': $permission = 'اطلاعات صورتحساب'; break;
            case 'daily-reports': $permission = 'گزارش روزانه'; break;
            case 'posts': $permission = 'پست ها'; break;
            case 'comments': $permission = 'نظرات'; break;
            case 'products': $permission = 'دوره ها'; break;
            case 'job-offers': $permission = 'فرصت های شغلی'; break;
            case 'categories': $permission = 'دسته بندی ها'; break;
            case 'job-applications': $permission = 'رزومه ها'; break;
            case 'orders': $permission = 'سفارش ها'; break;
            case 'menus': $permission = 'منو ها'; break;
            case 'discounts': $permission = 'تخفیف ها'; break;
            case 'podcasts': $permission = 'پادکست ها'; break;
            case 'student-reports': $permission = 'تحلیل های دانشپذیران'; break;
            case 'wallet-transactions': $permission = 'تراکنش ها کیف پول'; break;
            case 'roles': $permission = 'نقش ها'; break;
            case 'logs': $permission = 'لاگ'; break;
            case 'page': $permission = 'صفحه ساز'; break;
            case 'channels': $permission = 'کانال ها'; break;
            case 'channel-subscriptions': $permission = 'اشتراک های کانال'; break;
            case 'channel-members-count': $permission = 'تعداد اعضای کانال ها'; break;
            case 'carts': $permission = 'سبد خرید ها'; break;
            case 'subscriptions': $permission = 'اشتراک ها'; break;
            case 'reserves': $permission = 'رزرو ها'; break;
            case 'statistics': $permission = 'آمار'; break;
        }
        return $permission;
    }
@endphp
