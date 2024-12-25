@extends('admin::layouts.main')


@push('css')
    <link rel="stylesheet" href="/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/tagify/tagify.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h3>ساخت تحلیل جدید</h3>
            <hr>
            <div class="card mb-3">
                <div class="tab-content">
                    <form action="{{ route('admin.studentreports.store') }}" method="post" id="create-item"
                          enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-4">
                                <label class="form-label" for="analysis">تحلیل</label>
                                <input id="analysis" type="file" name="analysis" class="form-control"
                                       value="{{ old('analysis') }}">
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="date">تاریخ تحلیل</label>
                                <input type="text" class="form-control date-picker" id="date" name="date"
                                       value="{{ old('date') }}"
                                       autocomplete="off"
                                       required>
                            </div>
                            <div class="mb-3 col-4">
                                <label class="form-label" for="company">شرکت</label>
                                <input type="text" class="form-control" id="company" name="company"
                                       value="{{ old('company') }}"
                                       required>
                            </div>
                            <div class="row g-3">
                                <label for="adminEditor" class="form-label">توضیحات</label>
                                <textarea id="adminEditor" name="description">{{old('description')}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor')
    <x-admin::tinymce/>
    <x-admin::filemanager-btn/>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/tagify/tagify.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/i18n/defaults-fa_ir.js"></script>
    <script src="/assets/admin/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="/assets/admin/vendor/libs/bloodhound/bloodhound.js"></script>
    <script src="/assets/admin/js/main.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
    <script src="/assets/admin/js/forms-tagify.js"></script>
    <script src="/assets/admin/js/forms-typeahead.js"></script>
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date-picker").persianDatepicker({
                initialValue: false,
                format: 'YYYY/MM/DD',
                maxDate: new persianDate(),
            });
        });
    </script>
@endpush
