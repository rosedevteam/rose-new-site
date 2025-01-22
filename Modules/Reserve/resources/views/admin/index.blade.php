@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')

    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="flex-grow-1 p-3y">
            {{$reserves->appends(['search' => request('search'),'filter' => request('filter'), 'products' => request('products') , 'from' => request('from') , 'to' => request('to')])}}
            <!-- Users List Table -->
            <div class="card mx-4">
                <div class="row p-3">
                    <div class="d-flex align-items-center justify-content-between">


                        <!-- Modal Create -->
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title secondary-font" id="modalCenterTitle">افزودن رکورد
                                            جدید</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form method="post" id="createNewProduct"
                                          action="{{route('admin.products.store')}}">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="title" class="form-label">نام محصول</label>
                                                    <input type="text" name="title" id="title" class="form-control"
                                                           placeholder="نام را وارد کنید" value="{{old('title')}}">
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col mb-3">
                                                    <label for="price">قیمت</label>
                                                    <input type="text" name="price" id="price" class="form-control"
                                                           {{old('price')}}
                                                           placeholder="قیمت محصول">
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="sale_price">قیمت در تخفیف</label>
                                                    <input type="text" {{old('sale_price')}} name="sale_price"
                                                           id="sale_price"
                                                           class="form-control"
                                                           placeholder="قیمت فروش ویژه">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal">
                                                بستن
                                            </button>
                                            <button type="submit" class="btn btn-primary">افزودن</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title secondary-font" id="modalCenterTitle">ویرایش</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form id="EditProduct">
                                        <div class="modal-body">
                                            <input type="hidden" id="edit-product-id">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="title" class="form-label">نام محصول</label>
                                                    <input type="text" name="title" id="title" class="form-control"
                                                           placeholder="نام را وارد کنید" value="{{old('title')}}">
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col mb-3">
                                                    <label for="price">قیمت</label>
                                                    <input type="text" name="price" id="price" class="form-control"
                                                           {{old('price')}}
                                                           placeholder="قیمت محصول">
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="sale_price">قیمت در تخفیف</label>
                                                    <input type="text" {{old('sale_price')}} name="sale_price"
                                                           id="sale_price"
                                                           class="form-control"
                                                           placeholder="قیمت فروش ویژه">
                                                </div>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal">
                                                بستن
                                            </button>
                                            <button type="button" class="btn btn-primary" onclick="updateItem(event)">
                                                ویرایش
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <div class="d-flex align-items-center justify-content-between">
                                <a class="btn btn-secondary ms-2" data-bs-toggle="offcanvas" href="#filters"
                                   role="button"
                                   aria-controls="filters">
                                    <i class="bx bx-filter me-sm-1"></i>
                                    فیلتر ها
                                </a>
                                <a class="btn btn-info ms-2 text-white"
                                   onclick=" document.querySelector('#export').value = 1; document.querySelector('#filters-form').submit();"
                                   download>
                                    <i class="bx bx-download me-sm-1"></i>
                                    اکسپورت
                                </a>
                                <span class="ms-4">{{number_format($reserves->total())}}
                        آیتم</span>
                            </div>
                            <form action="" id="search">
                                <label class="d-flex align-items-center justify-content-between">
                                    <input type="text" class="form-control"
                                           placeholder="جستجو" id="search-key" name="search">
                                    <button class="btn btn-icon btn-primary ms-2" type="button" id="search-submit">
                                        <span class="tf-icons bx bx-search"></span>
                                    </button>
                                </label>
                            </form>
                        </div>


                    </div>

                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-users table border-top">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>محصولات</th>
                            <th>اطلاع رسانی اولیه</th>
                            <th>اطلاع رسانی بعد از موجود شدن</th>
                            <th>تاریخ رزرو</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reserves as $index => $reserve)

                            <tr>
                                <td>{{$index + 1}}</td>
                                <td class="d-flex flex-column">
                                    {{$reserve->name . ' ' . $reserve->lastname}}
                                    <small class="emp_post text-truncate text-muted">{{$reserve->phone}}</small>
                                </td>
                                <td>
                                    @foreach($reserve->products as $product)
                                        <span class="badge bg-secondary">
                                        {{$product->title}}
                                    </span>
                                    @endforeach
                                </td>
                                <td>
                                    @switch($reserve->is_notified)
                                        @case(1)
                                            <span class="badge bg-success">ارسال شده</span>
                                            @break
                                        @case(0)
                                            <span class="badge bg-warning">ارسال نشده</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($reserve->is_notified_after_product_availability)
                                        @case(1)
                                            <span class="badge bg-success">ارسال شده</span>
                                            @break
                                        @case(0)
                                            <span class="badge bg-warning">ارسال نشده</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{\Hekmatinasser\Verta\Verta::instance($reserve->created_at)->formatJalaliDate()}}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>

            </div>


            <div class="offcanvas offcanvas-end" tabindex="-1" id="filters" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">فیلتر ها</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="{{route('admin.reserves.index')}}" method="GET" id="filters-form">
                        <input type="hidden" name="filter" id="filter" value="1">
                        <input type="hidden" name="export" id="export" value="0">

                        <div class="mb-3">
                            <label for="select2Primary" class="form-label">دوره ها</label>
                            <div class="select2-primary">
                                <select id="select2Primary" name="products[]" class="select2 form-select"
                                        multiple>
                                    @foreach(\Modules\Product\Models\Product::all() as $product)
                                        <option value="{{$product->id}}"
                                                @if(request('products')) @if(in_array($product->id , request('products'))) selected @endif @endif>{{$product->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="from" class="form-label-sm my-1"> از تاریخ </label>
                                <input type="text" class="form-control mb-2" name="from" id="from" autocomplete="off"
                                       placeholder="از تاریخ" value="{{request('from')}}">

                            </div>
                            <div class="col-md-6">
                                <label for="to" class="form-label-sm my-1"> تا تاریخ </label>
                                <input type="text" class="form-control mb-2" name="to" id="to" autocomplete="off"
                                       placeholder="تا تاریخ" value="{{request('to')}}">

                            </div>
                        </div>

                        <button class="btn btn-primary" onclick="document.querySelector('#export').value = 0">
                            فیلتر
                        </button>
                    </form>
                </div>
            </div>

            {{$reserves->appends(['search' => request('search'), 'products' => request('products') , 'from' => request('from') , 'to' => request('to')])}}
        </div>
    </div>
@endsection

@section('vendor')
    {{--    todo fix datepicker--}}
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script src="/assets/aadmin/js/axios.js"></script>
    <script src="/assets/admin/js/search.js"></script>
    <script src="/assets/admin/js/product/all.js"></script>
    <script src="/assets/admin/js/product/create.js"></script>
    <script src="/assets/admin/js/product/edit.js"></script>
    <script src="/assets/admin/js/product/remove.js"></script>
@endsection


@push('script')
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
@endpush
