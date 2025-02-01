@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Weekly Order Summary -->
        <div class="flex-grow mx-4">
            <div class="col-xl-12 col-12 mb-4">
                <div class="card h-100">
                    <div class="row row-bordered m-0">
                        <!-- Order Summary -->
                        <div class="col-md-12 col-12 pe-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">گزارش سبد خرید ها</h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="orderSummaryChart"></div>
                            </div>
                        </div>
                        <!-- Sales History -->
                        <div class="col-md-4 col-12 px-0">
                            <div class="card-body">
                                <h6 class="mt-1">تعداد کل کاربران</h6>
                                <ul class="list-unstyled m-0 pt-0">
                                    <li class="mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-sm flex-shrink-0 me-2">
                                                <span class="avatar-initial rounded bg-label-primary"><i
                                                        class="bx bx-trending-up"></i></span>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-muted text-nowrap">تعداد کل کاربران</p>
                                                <small class="fw-semibold text-nowrap">
                                                    {{number_format(\Modules\Cart\Models\Cart::all()->count())}}
                                                    کاربر
                                                </small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('vendor')
    <script src="/assets/admin/js/axios.js"></script>
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="/assets/admin/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="/assets/admin/vendor/libs/block-ui/block-ui.js"></script>
@endpush

@push('script')
    <script src="/assets/admin/js/reports/carts.js"></script>
@endpush
