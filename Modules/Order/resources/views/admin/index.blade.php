@extends('admin::layouts.main')

@section('title')
    سفارش ها
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Users List Table -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.order.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-3 gap-md-0 primary-font">
                            <div class="col-md-2">
                                <label for="sort_by" class="form-label">ترتیب بر اساس: </label>
                                <select id="sort_by" name="sort_by" class="form-select text-capitalize">
                                    <option value="created_at" selected>تاریخ ساخت</option>
                                    <option value="price" {{ $sort_by == 'price' ? 'selected' : '' }}>قیمت
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">وضعیت: </label>
                                <select id="status" name="status" class="form-select text-capitalize">
                                    <option value="all" selected>همه</option>
                                    <option value="pending"{{ $status == 'pending' ? 'selected' : '' }}>در حال انجام
                                    </option>
                                    <option value="completed"{{ $status == 'completed' ? 'selected' : '' }}>کامل شده
                                    </option>
                                    <option value="cancelled"{{ $status == 'cancelled' ? 'selected' : '' }}>لغو شده
                                    </option>
                                    <option value="returned"{{ $status == 'returned' ? 'selected' : '' }}>پس گرفته
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">نوع پرداخت:</label>
                                <select id="status" name="status" class="form-select text-capitalize">
                                    <option value="all" selected>همه</option>
                                    <option value="shaparak"{{ $status == 'shaparak' ? 'selected' : '' }}>درگاه بانکی
                                    </option>
                                    <option value="card"{{ $status == 'card' ? 'selected' : '' }}>کارت به کارت</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sort_direction" class="form-label">نوع ترتیب: </label>
                                <select id="sort_direction" name="sort_direction" class="form-select text-capitalize">
                                    <option value="asc" selected>صعودی</option>
                                    <option value="desc"{{ $sort_direction == 'desc' ? 'selected' : '' }}>نزولی</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="count" class="form-label">تعداد: </label>
                                <select id="count" name="count" class="form-select text-capitalize">
                                    <option value="10" selected>10</option>
                                    <option value="20" {{ $count == "20" ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ $count == "50" ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $count == "100" ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="submit" type="submit" class="btn btn-primary mt-4 data-submit">جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="datatables-users table border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 12%" aria-sort="ascending">تاریخ ثبت
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 12%;">خریدار
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">دوره
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 15%;">قیمت فروش
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">وضعیت
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">روش پرداخت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr class="">
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-semibold">{{ verta($order->created_at)->formatJalaliDate() }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                <span class="fw-semibold">
                                    <a href="{{ route('admin.user.show', $order->user) }}"
                                    {{ $order->user->name() }}
                                </span>
                                    </td>
                                    <td><span class="fw-semibold">{{ $order->product->title }}</span></td>
                                    <td>{{ $order->price }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            {{ $order->payment_method }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>

                </div>
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
@endpush
