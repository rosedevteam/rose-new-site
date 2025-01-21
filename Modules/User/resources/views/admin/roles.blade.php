@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
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
                                    colspan="1" style="width: 10%" aria-sort="ascending">عنوان
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">جزییات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $role->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            <button class="btn btn-sm btn-info" data-bs-target="#editRoleModal"
                                                    data-bs-toggle="modal"
                                                    data-name="{{ $role->name }}"
                                                    data-permissions="{{ json_encode($role->permissions->pluck('name')->toArray()) }}"
                                                    data-route="{{ route('admin.roles.update', $role) }}"
                                                    id="edit-button">
                                                ویرایش
                                            </button>
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
                                                دسترسی مدیریت
                                                <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="Allows a full access to the system"></i>
                                            </td>
                                            <td>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                    <label class="form-check-label" for="selectAll"> انتخاب همه </label>
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
