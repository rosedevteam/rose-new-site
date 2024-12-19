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
                            @include('menu::admin.partials.menu-group' ,
                     ['menus' => $menus ,  'child' => false , 'level' => 0])

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
                                    <label class="form-label" for="title">نام</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{old('title')}}"
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">توضیحات (مخصوص زیر منو)</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle"
                                           value="{{old('subtitle')}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="link">لینک</label>
                                    <input type="text" class="form-control" id="link" name="link"
                                           {{old('link')}}
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="order">ترتیب</label>
                                    <input type="text" class="form-control" id="order" name="order"
                                           {{old('order')}}
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label for="image_label">آیکن</label>
                                    <div class="input-group">
                                        <input type="text" id="image_label" class="form-control" name="image"
                                               aria-label="Image" aria-describedby="button-image"
                                               value="{{ old('image') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-image">
                                                انتخاب
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="parent_id">منوی مادر</label>
                                    <select name="parent_id" id="parent_id" class="form-select">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($menus as $menu)
                                            <option value="{{$menu->id}}" {{old('parent_id') ? $menu->id : 'selected'}}>{{$menu->title}}</option>
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
@endpush

@push('script')
    <x-admin::filemanager-btn/>
@endpush
