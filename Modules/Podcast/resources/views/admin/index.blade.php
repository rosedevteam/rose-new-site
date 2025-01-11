@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="col d-flex justify-content-between">
                        <h5 class="card-title me-2" style="display: inline">پادکست ها</h5>
                        <button class="btn btn-primary my-3" data-bs-target="#create-podcast" data-bs-toggle="offcanvas"
                                type="button">ساخت پادکست
                        </button>
                    </div>
                </div>
                <div class="table-responsive mb-3">
                    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="table datatable-invoice border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info"
                               style="width: 100%;">
                            <thead>
                            <tr>
                                <th tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                    style="width: 2%;">عنوان
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1"
                                    colspan="1" style="width: 3%;">نویسنده
                                </th>
                                <th class="control sorting dtr-hidden" tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                    style="width: 5%;">تاریخ ساخت
                                </th>
                                @can('edit-wallet-transactions')
                                    <th class="control sorting dtr-hidden" tabindex="0"
                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                        style="width: 5%;">ویرایش
                                    </th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($podcasts as $podcast)
                                <tr>
                                    <td>{{ $podcast->title }}</td>
                                    <td><a class="text-body"
                                           href="{{ route('admin.users.edit', $podcast->user) }}">{{ $podcast->user->name() }}</a>
                                    </td>
                                    <td>{{ verta($podcast->created_at)->formatJalaliDatetime() }}</td>
                                    @can('edit-podcasts')
                                        <td>
                                            <a href="{{ route('admin.podcasts.edit', $podcast) }}">
                                                <button class="btn btn-sm btn-primary">
                                                    ویرایش
                                                </button>
                                            </a>
                                            @can('delete-podcasts')
                                                <x-admin::deletebutton data-id="{{ $podcast->id }}"/>
                                            @endcan
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $podcasts->links() }}
                    </div>
                </div>
                @can('create-podcasts')
                    <div class="offcanvas offcanvas-end" id="create-podcast"
                         aria-labelledby="offcanvasAddUserLabel">
                        <div class="offcanvas-header border-bottom">
                            <h6 id="offcanvasAddUserLabel" class="offcanvas-title">افزودن پادکست</h6>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body mx-0 flex-grow-0">
                            <form class="add-new-user pt-0"
                                  action="{{ route('admin.podcasts.store') }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="title">نام</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{old('title')}}"
                                           required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="image">تصویر</label>
                                    <input id="image" type="file" name="image" class="form-control">
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
    <x-admin::deletemodalscript model="podcasts"/>
@endpush
