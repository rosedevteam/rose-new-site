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
            <div class="row">
                <div class="col-md-8">
                    <h3>ویرایش تحلیل</h3>
                    <hr>
                    <div class="card mb-3">
                        <div class="tab-content">
                            <form action="{{ route('admin.studentreports.update', $studentreport) }}" method="post"
                                  id="edit-item"
                                  enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="row">
                                    <div class="row g-3">
                                        <label for="adminEditor" class="form-label">توضیحات</label>
                                        <textarea id="adminEditor"
                                                  name="description">{{ $studentreport->description }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="ps-3 p-3 d-flex align-items-center justify-content-between">
                            <h5>جزییات</h5>
                            <a href="{{route('admin.studentreports.index')}}">بازگشت</a>

                        </div>
                        <hr>
                        <div class="ps-3 p-3">
                            <div class="mb-3">
                                <label class="form-label" for="analysis">تحلیل</label>
                                <input id="analysis" type="file" name="analysis" class="form-control" form="edit-item"
                                       value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="date">تاریخ تحلیل</label>
                                <input type="text" class="form-control date-picker" id="date" name="date"
                                       value="{{ $studentreport->date }}"
                                       autocomplete="off" form="edit-item"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="company">شرکت</label>
                                <input type="text" class="form-control" form="edit-item" id="company" name="company"
                                       value="{{ $studentreport->company }}"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="form-select" name="status" id="status" form="edit-item">
                                    <option
                                        value="approved" {{ $studentreport->status == 'approved' ? 'selected' : '' }}>
                                        تایید شده
                                    </option>
                                    <option
                                        value="rejected" {{ $studentreport->status == 'rejected' ? 'selected' : '' }}>رد
                                        شده
                                    </option>
                                    <option value="pending" {{ $studentreport->status == 'pending' ? 'selected' : '' }}>
                                        در انتظار
                                    </option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="submit" class="btn btn-primary" form="edit-item">ثبت</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="ps-3 p-3 d-flex align-items-center justify-content-between">
                            <h5>فایل فعلی</h5>
                        </div>
                        <hr>
                        <div class="ps-3 pe-3 mb-3">
                            <a href="{{ route('admin.studentreports.analysis', $studentreport) }}">{{ $studentreport->analysis }}</a>
                        </div>

                    </div>
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
                initialValueType: "persian",
                autoClose: true,
                format: 'YYYY/MM/DD',
                maxDate: new persianDate(),
            });
        });
    </script>
@endpush
