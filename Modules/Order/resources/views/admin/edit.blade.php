@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/tagify/tagify.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css">
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-8">
                    <h3>ویرایش سفارش {{$order->id}}#</h3>
                    <hr>
                    <div class="card mb-3">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-tabs card-header-tabs primary-font" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#form-tabs-post"
                                            role="tab" aria-selected="false" tabindex="-1">
                                        جزئیات
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.orders.update' , $order) }}" method="post" id="edit-item">
                            @method('patch')
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="created_at">تاریخ سفارش</label>
                                            <input type="text" class="date-picker form-control" name="created_at"
                                                   autocomplete="off" value="{{$order->created_at ?? old('created_at')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="select2Basic" class="form-label">موبایل کاربر</label>
                                            <select name="user_id" id="select2Basic" class="form-select select2" required>
                                                <option value="">انتخاب کنید</option>
                                                @foreach(\App\Models\User::all() as $user)
                                                    <option
                                                        value="{{$user->id}}" {{$order->user_id == $user->id ? 'selected' : ''}}>{{$user->phone . ' | ' . $user->first_name . ' ' .$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="select2Primary" class="form-label">دوره ها</label>
                                            <div class="select2-primary">
                                                <select id="select2Primary" class="select2 form-select"
                                                        name="products[]" multiple>
                                                    @foreach(\Modules\Product\Models\Product::all() as $product)
                                                        <option
                                                            value="{{ $product->id }}" {{$order->products->contains($product) ? 'selected' : ''}}>{{ $product->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="watermark" class="form-label">واتر مارک</label>
                                            <input type="text" class="form-control" name="watermark" id="watermark"
                                                   placeholder="مثلا: +۹۸۹۱۲۱۲۳۰۳۷۴" value="{{old('watermark')}}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="card mb-3">
                        <div class="ps-3 p-3 d-flex align-items-center justify-content-between">
                            <h5>جزییات</h5>
                            <a href="{{route('admin.orders.index')}}">بازگشت</a>

                        </div>
                        <hr>

                        <div class="ps-3 p-3">
                            <div class="mb-3">
                                <label class="form-label" for="status">وضعیت سفارش</label>
                                <select class="form-select" name="status" id="status"
                                        form="create-item">
                                    <option value="">انتخاب کنید</option>
                                    <option value="completed" {{old('status') == 'completed' ? 'selected' : ''}}>تکمیل
                                        شده
                                    </option>
                                    <option value="pending" {{old('status') == 'pending' ? 'selected' : ''}}>در حال
                                        انجام
                                    </option>
                                    <option value="cancelled" {{old('status') == 'cancelled' ? 'selected' : ''}}>لغو
                                        شده
                                    </option>
                                    <option value="returned" {{old('status') == 'returned' ? 'selected' : ''}}>عودت داده
                                        شده
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="payment_method">نوع پرداخت</label>
                                <select class="form-select" name="payment_method" id="payment_method"
                                        form="create-item">
                                    <option value="">انتخاب کنید</option>
                                    <option value="card" {{old('status') == 'card' ? 'selected' : ''}}>کارت به کارت
                                    </option>
                                    <option value="shahparak" {{old('status') == 'shahparak' ? 'selected' : ''}}>پرداخت
                                        اینترنتی
                                    </option>
                                </select>
                            </div>

                            <div class="my-3">
                                <label for="short-description" class="form-label">یادداشت</label>
                                <textarea class="form-control" rows="8" name="notes" id="notes"
                                          form="create-item">{{old('notes')}}</textarea>
                            </div>

                            <div class="pt-4 d-flex align-items-center justify-content-between">
                                <button type="submit" class="btn btn-sm btn-primary " form="create-item">ایجاد آیتم
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/tagify/tagify.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date-picker").persianDatepicker({
                initialValue: true,
                format: 'YYYY/MM/DD HH:mm:ss',
                // minDate: new persianDate(),
                timePicker: {
                    enabled: true,
                    meridian: {
                        enabled: false,
                    },
                },
            });
        });
    </script>
@endpush
