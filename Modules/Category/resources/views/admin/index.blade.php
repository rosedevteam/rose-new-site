@extends('admin::layouts.main')


@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
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
                                            value="{{ $t }}" {{ $t == $type ? 'selected' : ''}}>@switch($t)
                                                @case('post')پست@break
                                                @case('joboffer')فرصت شغلی@break
                                                @case('product')دوره@break
                                            @endswitch</option>
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
                                    style="width: 10%;">برای
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">کتگوری مادر
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">آدرس آرشیو
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">نویسنده
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">تاریخ ساخت
                                </th>
                                @can('edit-categories')
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">عملیات
                                </th>
                                @endcan
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
                                    <td><span class="fw-semibold">@switch($category->type)
                                                @case('post')پست@break
                                                @case('joboffer')فرصت شغلی@break
                                                @case('product')دوره@break
                                            @endswitch</span></td>
                                    <td>{{ $category->parent?->name ?: 'ندارد' }}</td>
                                    <td>{{ $category->archive_slug ?: 'ندارد' }}</td>
                                    <td>@can('view-users')
                                            <a href="{{ route('admin.users.show', $category->user) }}"
                                               class="text-body text-truncate">{{ $category->user->name() }}</a>
                                        @else
                                            {{ $category->user->name() }}
                                        @endcan</td>
                                    <td>{{ verta($category->created_at)->formatJalaliDateTime() }}</td>
                                    @can('edit-categories')
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            @can('edit-categories')
                                                <button class="btn btn-sm btn-info" data-bs-target="#edit-modal"
                                                        data-bs-toggle="modal"
                                                        data-name="{{ $category->name }}"
                                                        data-slug="{{ $category->archive_slug }}"
                                                        data-id="{{ $category->id }}"
                                                        data-parent="{{ $category->parent_id }}"
                                                        data-type="{{ $category->type }}"
                                                        id="edit-button">
                                                    ویرایش
                                                </button>
                                            @endcan
                                            @can('delete-categories')
                                                <x-admin::deletebutton data-id="{{ $category->id }}"/>
                                            @endcan
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>

                </div>
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
                                            <option value="{{ $t }}">@switch($t)
                                                    @case('post')پست@break
                                                    @case('joboffer')فرصت شغلی@break
                                                    @case('product')دوره@break
                                                @endswitch</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="parent_id">دسته بندی مادر:</label>
                                    <select id="parent_id" name="parent_id" class="form-select">
                                        <option value="">ندارد</option>
                                        @foreach($parents as $c)
                                            <option value="{{ $c->id }}"
                                                    data-type="{{ $c->type }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="archive_slug">آدرس آرشیو</label>
                                    <input type="text" class="form-control" id="archive_slug" name="archive_slug">
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
            <div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            <div class="text-center mb-4 mt-0 mt-md-n2">
                                <h3 class="secondary-font">ویرایش دسته بندی</h3>
                            </div>
                            <form id="edit-form" class="row g-3"
                                  method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label class="form-label" for="name_edit">نام</label>
                                    <input type="text" class="form-control" id="name_edit" name="name_edit" value=""
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="parent_id_edit">دسته بندی مادر</label>
                                    <select id="parent_id_edit" name="parent_id_edit" class="form-select">
                                        <option value="">ندارد</option>
                                        @foreach($parents as $c)
                                            <option value="{{ $c->id }}" class="form-control"
                                                    data-type="{{ $c->type }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" value="" id="type_edit" name="type_edit">
                                <div class="mb-3">
                                    <label class="form-label" for="archive_slug_edit">آدرس آرشیو</label>
                                    <input type="text" class="form-control" id="archive_slug_edit"
                                           name="archive_slug_edit" value="">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.addEventListener('click', (event) => {
                if (event.target.matches('#edit-button')) {
                    const id = event.target.getAttribute('data-id');
                    const name = event.target.getAttribute('data-name');
                    const slug = event.target.getAttribute('data-slug');
                    const type = event.target.getAttribute('data-type');
                    const parentId = event.target.getAttribute('data-parent');
                    document.getElementById('name_edit').value = name;
                    document.getElementById('archive_slug_edit').value = slug;
                    document.getElementById('type_edit').value = type;
                    document.getElementById('edit-form').action = `categories/${id}`;
                    const p = document.getElementById('parent_id_edit');
                    Array.from(p.options).forEach(option => {
                        if (option.value === "") {
                            option.style.display = "";
                        } else if (option.getAttribute("data-type") === type && option.value !== id) {
                            option.style.display = "";
                        } else {
                            option.style.display = "none";
                        }
                        option.selected = String(option.value) === String(parentId);
                    });

                    p.value = parentId || "";
                }
            });
        });
    </script>
@endpush
