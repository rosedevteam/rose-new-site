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
            <div class="card mb-3">
                <div class="tab-content">
                    <form action="{{ route('admin.discounts.update', $discount) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="code">کد</label>
                                <input type="text" class="form-control" id="code" name="code"
                                       value="{{ $discount->code }}" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="is_active">وضعیت</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1" {{ $discount->is_active ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ $discount->is_active ? 'selectes' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="type">نوع</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="amount" {{ $discount->type == 'amount' ? 'selected' : '' }}>مقدار
                                    </option>
                                    <option value="percentage" {{ $discount->type == 'percentage' ? 'selected' : '' }}>
                                        درصد
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="amount">مقدار</label>
                                <input class="form-control" id="amount" name="amount"
                                       value="{{ $discount->amount }}" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="expires_at">تاریخ انقضا</label>
                                <input type="text" class="date-picker form-control"
                                       value="{{ verta($discount->expires_at)->format('Y/m/d H:i') }}"
                                       name="expires_at" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="limit">محدودیت استفاده</label>
                                <input type="number" class="form-control" name="limit" id="limit" value="{{ $discount->limit }}"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg mb-4">
                                <label for="select2Primary" class="form-label">دوره ها</label>
                                <div class="select2-primary">
                                    <select id="select2Primary" class="select2 form-select" name="products[]" multiple>
                                        @foreach($products as $product)
                                            <option
                                                value="{{ $product->id }}" {{ $discount->products->contains($product) ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">ثبت تغییرات</button>
                        </div>
                    </form>
                    @can('delete-discounts')
                        <div class="mx-2 mt-3">
                            <x-admin::deletebutton/>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mb-4 mt-0 mt-md-n2">
                            <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                        </div>
                        <form id="deleteForm" action="{{ route("admin.discounts.destroy", $discount) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-danger me-sm-3 me-1">حذف</button>
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
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/tagify/tagify.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/i18n/defaults-fa_IR.js"></script>
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
                format: 'YYYY/MM/DD HH:mm',
                minDate: new persianDate(),
                autoClose: true,
                timePicker: {
                    enabled: true,
                    meridian: {
                        enabled: false,
                    },
                    second: {
                        enabled: false,
                    }
                },
            });
        });
    </script>
@endpush
