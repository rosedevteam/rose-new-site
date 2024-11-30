@extends('admin::layouts.main')

@section('title')
    دوره ها
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Users List Table -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.product.index') }}" method="GET">
                        <div class="d-flex justify-content-start align-items-center row py-3 gap-3 gap-md-0 primary-font">
                            <div class="col-md-3">
                                <label for="title" class="form-label">جستجو: </label>
                                <div id="search" class="search-input">
                                    <input type="search" name="search" value="{{ $search }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="sort_by" class="form-label">ترتیب بر اساس: </label>
                                <select id="sort_by" name="sort_by" class="form-select text-capitalize">
                                    <option value="created_at" selected>تاریخ ساخت</option>
                                    <option value="title" {{ $sort_by == 'first_name' ? 'selected' : '' }}>نام
                                    </option>
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
                        @can('create-products')
                            <div class="row mx-2 my-2">
                                <div class="col-md-20">
                                    <div
                                            class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <button class="btn btn-secondary add-new btn-primary ms-2" tabindex="0"
                                                    aria-controls="DataTables_Table_0" type="button"><span><i
                                                            class="bx bx-plus me-0 me-lg-2"></i><span
                                                            class="d-none d-lg-inline-block">ساخت دوره جدید</span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <table class="datatables-users table border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">تاریخ ساخت
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 12%" aria-sort="ascending">نام
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">قیمت اصلی
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 15%;">قیمت فروش
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">وضعیت
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">نویسنده
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr class="">
                                    <td>{{ verta($product->created_at)->formatJalaliDate() }}</td>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column"><a
                                                        href="{{ route('admin.product.show', $product) }}"
                                                        class="text-body text-truncate">
                                                    <span class="fw-semibold">{{ $product->title }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="fw-semibold">{{ $product->price }}</span></td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ $product->status }}</span>
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            <a href="{{ route('admin.user.show', $product->author()) }}">
                                                {{ $product->author()->name() }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
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
