@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row mx-2 my-2">
                            <div class="col-md-20">
                                <div
                                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                    <div class="dt-buttons btn-group flex-wrap">
                                        @can('create-menus')
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
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">ردیف
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 12%;">نام
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 12%;">لینک
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
                            @foreach($menus as $menu)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $menu?->order ?: 'غیر فعال'}}
                                    </td>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $menu->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $menu->slug }}</td>
                                    <td>
{{--                                <span class="fw-semibold">--}}
{{--                                                <a href="{{ route("admin.users.show", $menu->author) }}"--}}
{{--                                                   class="text-body text-truncate">--}}
{{--                                    {{ $menu->author->name() }}--}}
{{--                                                </a>--}}
{{--                                </span>--}}
                                    </td>
                                    <td>{{ verta($menu->created_at)->formatJalaliDateTime() }}</td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
{{--                                            <button class="btn btn-sm btn-icon">--}}
{{--                                                <a href="{{ route('admin.menus.show', $menu) }}">--}}
{{--                                                    <i class="bx bx-detail"></i>--}}
{{--                                                </a>--}}
{{--                                            </button>--}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
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
                                    <label class="form-label" for="link">لینک</label>
                                    <input type="text" class="form-control" id="link" name="link"
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="order">ترتیب</label>
                                    <input type="text" class="form-control" id="order" name="order"
                                           required>
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
            }).then(_ => {
                location.reload()
            })
        });
    </script>
@endpush
