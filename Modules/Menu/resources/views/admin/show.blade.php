@extends('admin::layouts.main')

@section('title')
    زیر گروه
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom">
                    <div
                        class="d-flex justify-content-start align-items-center row py-3 gap-1 gap-md-0 primary-font">
                        <div class="row">
                            <div class="col-md-2">نام:
                                {{ $menu->name }}
                            </div>
                            <div class="col-md-2">لینک:
                                {{ $menu->slug }}
                            </div>
                            @can('edit-menus')
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary ms-2"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasEdit">ویرایش
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
                @if($menu->has_children)
                    <div class="card-datatable table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row mx-2 my-2">
                                <div class="col-md-20">
                                    <div
                                        class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            @can('edit-menu-entries')
                                                <button type="button" class="btn btn-primary ms-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCenter">ویرایش ترتیب
                                                </button>
                                            @endcan
                                            @can('create-menu-entries')
                                                <button class="btn btn-secondary add-new btn-primary ms-2"
                                                        aria-controls="DataTables_Table_0" type="button"
                                                        data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasAddUser"><span><i
                                                            class="bx bx-plus me-0 me-lg-2"></i><span
                                                            class="d-none d-lg-inline-block">ساخت آیتم منو جدید</span></span>
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="datatables-users table border-top dataTable no-footer dtr-column"
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
                                   style="width: 100%;">
                                <thead>
                                <tr>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">ردیف
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 12%;">نام
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 10%;">نویسنده
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">تاریخ ساخت
                                    </th>
                                    <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">جزییات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($active as $menuEntry)
                                    <tr>
                                        <td class="fw-semibold">
                                            {{ $menuEntry?->order ?: 'غیر فعال'}}
                                        </td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $menuEntry->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                <span class="fw-semibold">
                                    {{ $menuEntry->author->name() }}
                                </span>
                                        </td>
                                        <td>{{ verta($menuEntry->created_at)->formatJalaliDateTime() }}</td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <button class="btn btn-sm btn-icon">
                                                    <a href="{{ route('admin.menus.show', $menuEntry) }}">
                                                        <i class="bx bx-detail"></i>
                                                    </a>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach($inactive as $menuEntry)
                                    <tr>
                                        <td class="fw-semibold">غیر فعال
                                        </td>
                                        <td class="sorting_1">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $menuEntry->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                <span class="fw-semibold">
                                    {{ $menuEntry->author->name() }}
                                </span>
                                        </td>
                                        <td>{{ verta($menuEntry->created_at)->formatJalaliDateTime() }}</td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <button class="btn btn-sm btn-icon">
                                                    <a href="{{ route('admin.menus.show', $menuEntry) }}">
                                                        <i class="bx bx-detail"></i>
                                                    </a>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    @can('edit-menus')
                        <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title secondary-font" id="modalCenterTitle">ویرایش ترتیب</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12 mb-md-0 mb-4">
                                                                <p>فعال</p>
                                                                <ul class="list-group list-group-flush" id="active">
                                                                    @foreach($active as $item)
                                                                        <li class="list-group-item drag-item cursor-move d-flex justify-content-between align-items-center"
                                                                            data-id="{{ $item->id }}" style="">
                                                                            <span>{{ $item->name }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6 col-12 mb-md-0 mb-4">
                                                                <p>غیر فعال</p>
                                                                <ul class="list-group list-group-flush" id="inactive">
                                                                    @foreach($inactive as $item)
                                                                        <li class="list-group-item drag-item cursor-move d-flex justify-content-between align-items-center"
                                                                            data-id="{{ $item->id }}" style="">
                                                                            <span>{{ $item->name }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                            بستن
                                        </button>
                                        <button type="button" id="edit-order" class="btn btn-primary"
                                                data-bs-dismiss="modal">
                                            ویرایش
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can('create-menus')
                        <div class="offcanvas offcanvas-end" id="offcanvasAddUser"
                             aria-labelledby="offcanvasAddUserLabel">
                            <div class="offcanvas-header border-bottom">
                                <h6 id="offcanvasAddUserLabel" class="offcanvas-title">افزودن آیتم جدید</h6>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form class="add-new-user pt-0" id="addNewUserForm"
                                      action="{{ route('admin.menus.store') }}"
                                      method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="name">نام</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="slug">لینک</label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                               required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="slug">آیکون</label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                               required>
                                    </div>
                                    <input type="hidden" value="{{ $menu->id }}" name="parent_id">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">ثبت</button>
                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">
                                        انصراف
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                    @can('edit-menus')
                        <div class="offcanvas offcanvas-end" id="offcanvasEdit"
                             aria-labelledby="offcanvasAddUserLabel">
                            <div class="offcanvas-header border-bottom">
                                <h6 id="offcanvasAddUserLabel" class="offcanvas-title">ویرایش منو</h6>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="name" class="form-label">نام</label>
                                            <input id="name" name="name" class="form-control" type="text"
                                                   value="{{ $menu->name }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="slug" class="form-label">لینک</label>
                                            <input id="slug" name="slug" class="form-control" type="text"
                                                   value="{{ $menu->slug }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="has_submenus">زیر گروه</label>
                                            <select class="form-select" id="has_submenus" name="has_submenus">
                                                <option class="form-control" value="1" selected>دارد</option>
                                                <option class="form-control" value="0">ندارد</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan
                @endif
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
    <script src="/assets/admin/vendor/libs/sortablejs/sortable.js"></script>
    <script src="/assets/admin/js/extended-ui-drag-and-drop.js"></script>
    <script>
        document.getElementById('edit-order').addEventListener('click', function () {
            const pendingTasks = [...document.querySelectorAll('#active > li')].map((el, index) => ({
                id: el.dataset.id,
                order: index + 1,
                status: true
            }));

            const completedTasks = [...document.querySelectorAll('#inactive > li')].map((el, index) => ({
                id: el.dataset.id,
                order: index + 1,
                status: false
            }));

            const sortedData = [...pendingTasks, ...completedTasks];

            fetch('{{ route('admin.menus.sort') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(sortedData)
            }).then(response => {
                if (response.ok) {
                    location.reload()
                }
            })
        });
    </script>
@endpush
