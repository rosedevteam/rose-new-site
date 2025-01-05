@extends("admin::layouts.main")

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">آمار وب‌سایت</h5>
                        </div>
                        <div class="card-body pb-2">
                            <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                                <div class="user-analytics text-center me-2">
                                    <i class="bx bx-user me-1"></i>
                                    <span>کاربران</span>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="chart-report" data-color="success" data-series="35"></div>
                                        <h3 class="mb-0">{{ $userCount }}</h3>
                                    </div>
                                </div>
                                <div class="sessions-analytics text-center me-2">
                                    <i class="bx bx-food-menu me-1"></i>
                                    <span>سفارش ها</span>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="chart-report" data-color="warning" data-series="76"></div>
                                        <h3 class="mb-0">{{ $orderCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">آخرین سفارش ها</h5>
                    <div class="card-datatable table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <table class="datatables-users table border-top dataTable no-footer dtr-column"
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
                                   style="width: 100%;">
                                <thead>
                                <tr>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 12%;">خریدار
                                    </th>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 15%;">دوره ها
                                    </th>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">قیمت خرید
                                    </th>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">وضعیت
                                    </th>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">روش پرداخت
                                    </th>
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 12%" aria-sort="ascending">تاریخ ثبت
                                    </th>
                                    @can('edit-orders')
                                        <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 5%" aria-sort="ascending">جزییات
                                        </th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latestOrders as $order)
                                    <tr class="">
                                        <td>
                                            @can('view-users')
                                                <a href="{{ route('admin.users.show', $order->user->first()) }}"
                                                   class="text-body text-truncate"><span
                                                        class="fw-semibold">{{ $order->user->name() }}</span> </a>
                                            @else
                                                {{ $order->user->name() }}
                                            @endcan
                                        </td>
                                        <td>
                                            @php
                                                $len = count($order->products()->get())-1;
                                                $i = 0
                                            @endphp
                                            @foreach($order->products()->get() as $product)
                                                @can('view-products')
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                       class="text-body text-truncate"><span
                                                            class="fw-semibold">{{ $product->title . ($i != $len ? "، " : "") }}</span></a>
                                                @else
                                                    <span
                                                        class="fw-semibold">{{ $product->title . ($i != $len ? "، " : "") }}</span>
                                                @endcan
                                                @php $i++ @endphp
                                            @endforeach
                                        </td>
                                        <td>{{ number_format($order->price) }}
                                            تومان
                                        </td>
                                        <td>
                                        <span class="fw-semibold">
                                            @switch($order->status)
                                                @case('completed')
                                                    <span class="badge bg-success">کامل شده</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-secondary">در حال انجام</span>
                                                    @break
                                                @case('returned')
                                                    <span class="badge bg-warning">عودت داده شده</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">لغو شده</span>
                                                    @break
                                            @endswitch
                                        </span>
                                        </td>
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                @switch($order->payment_method)
                                                    @case('shaparak')درگاه@break
                                                    @case('card')کارت به کارت@break
                                                @endswitch
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="d-flex flex-column">
                                                <span
                                                    class="fw-semibold">{{ verta($order->created_at)->formatJalaliDate() }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        @can('edit-orders')
                                            <td>
                                                <div class="d-flex gap-3 text-nowrap">
                                                    <a href="{{ route('admin.orders.edit', $order) }}"
                                                       class="btn btn-sm btn-info">
                                                        ویرایش
                                                    </a>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/apex-charts/apexcharts.js"></script>
@endpush

@push('script')
    <script src="/assets/admin/js/dashboards-analytics.js"></script>
@endpush
