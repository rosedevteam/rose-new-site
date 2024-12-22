@extends('admin::layouts.main')


@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Users List Table -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.categories.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-1 gap-md-0 primary-font">
                            <div class="col-md-2">
                                <label for="type" class="form-label">نوع: </label>
                                <select id="type" name="type" class="form-select text-capitalize">
                                    <option value="all" selected>همه</option>
                                    @foreach($types as $t)
                                        <option
                                            value="{{ $t }}" {{ $t == $type ? 'selected' : ''}}>{{ $t }}</option>
                                    @endforeach
                                </select></div>
                            <div class="col-md-1">
                                <button id="submit" type="submit" class="btn btn-primary mt-4 data-submit">جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        @can('create-categories')
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
                                                        class="d-none d-lg-inline-block">ساخت کتکوری جدید</span></span>
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
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">نام
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 15%;">برای
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">کتگوری مادر
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">نویسنده
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">تاریخ ساخت
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">عملیات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $category->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-semibold">{{ $category->type }}</span></td>
                                    <td>{{ $category->parent?->name ?: 'ندارد' }}</td>
                                    <td><a href="{{ route('admin.users.show', $category->user) }}"
                                           class="text-body text-truncate">{{ $category->user->name() }}</a></td>
                                    <td>{{ verta($category->created_at)->formatJalaliDateTime() }}</td>
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            @can('delete-categories')
                                                <x-admin::deletebutton data-id="{{ $category->id }}"/>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>

                </div>
                <!-- Offcanvas to add new user -->
                @can('create-categories')
                    <div class="offcanvas offcanvas-end" id="offcanvasAddUser"
                         aria-labelledby="offcanvasAddUserLabel">
                        <div class="offcanvas-header border-bottom">
                            <h6 id="offcanvasAddUserLabel" class="offcanvas-title">ساخت کتکوری</h6>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body mx-0 flex-grow-0">
                            <form class="add-new-user pt-0" id="addNewUserForm"
                                  action="{{ route('admin.categories.store') }}"
                                  method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="name">نام</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="type_create">برای</label>
                                    <select id="type_create" name="type_create" class="form-select"
                                            onchange="filterOptions()"
                                            required>
                                        <option value="" disabled selected></option>
                                        @foreach($types as $t)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="parent_id">کتگوری مادر:</label>
                                    <select id="parent_id" name="parent_id" class="form-select">
                                        <option value="" selected>ندارد</option>
                                        @foreach($parents as $c)
                                            <option value="{{ $c->id }}"
                                                    data-type="{{ $c->type }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
    <x-admin::deletemodalscript model="categories"/>
    <script>
        function filterOptions() {
            const selectedType = document.getElementById("type_create").value;
            const parentSelect = document.getElementById("parent_id");
            console.log("Selected Type:", selectedType);
            console.log(parentSelect)

            Array.from(parentSelect.options).forEach(option => {
                if (option.value === "") {
                    option.style.display = "";
                } else if (option.getAttribute("data-type") === selectedType) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                }
            });

            parentSelect.value = "";
        }
    </script>
@endpush
