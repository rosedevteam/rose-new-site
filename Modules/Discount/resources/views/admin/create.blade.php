@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-3">
                <form action="{{ route('admin.discounts.store') }}" method="post">
                    @csrf
                    <div class="tab-content">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="code">کد</label>
                                <input type="text" class="form-control" id="code" name="code" autocomplete="off"
                                       value="{{ old('code') }}"
                                       required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="is_active">وضعیت</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1" selected>فعال</option>
                                    <option value="0" {{ old('id_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="expires_at">تاریخ انقضا</label>
                                <input type="text" class="date-picker form-control" name="expires_at"
                                       value="{{ old("expires_at") }}"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="amount">مقدار</label>
                                <input class="form-control" id="amount" name="amount" autocomplete="off"
                                       value="{{ old('amount') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="limit">محدودیت استفاده</label>
                                <input type="number" class="form-control" name="limit" id="limit"
                                       value="{{ old('limit') }}"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 mb-4">
                                <label for="select2Primary" class="form-label">دوره ها</label>
                                <div class="select2-primary">
                                    <select id="select2Primary" class="select2 form-select" name="products[]" multiple>
                                        @foreach($products as $product)
                                            <option
                                                value="{{ $product->id }}" {{ in_array($product->id, old('products') ?: []) ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">ثبت</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date-picker").persianDatepicker({
                initialValue: false,
                format: 'YYYY/MM/DD HH:mm',
                autoClose: true,
                minDate: new persianDate(),
                timePicker: {
                    enabled: true,
                    meridian: {
                        enabled: false,
                    },
                    second: {
                        enabled: false,
                    },
                },
            });
        });
    </script>
    <script src="/assets/admin/js/autonumeric/autonumeric.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const amount = new AutoNumeric('#amount', {
                digitGroupSeparator: ',',
                minimumValue: '0',
                unformatOnSubmit: true,
                decimalPlaces: 0,
            });
        });
    </script>
@endpush
