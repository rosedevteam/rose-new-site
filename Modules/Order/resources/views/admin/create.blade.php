@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-8">
                    <h3>افزودن سفارش جدید</h3>
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
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-price"
                                            role="tab"
                                            aria-selected="true">
                                        موارد سفارش
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.orders.store') }}" method="post" id="create-item">
                            @method('post')
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="created_at">تاریخ سفارش</label>
                                            <input type="text" class="date-picker form-control" name="created_at"
                                                   autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">موبایل کاربر</label>
                                            <input type="text" class="form-control" placeholder="موبایل" onchange="findUser()">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                                    <div class="row g-3">

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="form-tabs-price" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="price">قیمت عادی</label>
                                            <input type="text" id="price" name="price" class="form-control text-start"
                                                   dir="ltr">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="sale_price">قیمت فروش ویژه</label>
                                            <input type="text" id="sale_price" name="sale_price" class="form-control">
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
                            <a href="{{route('admin.posts.index')}}">بازگشت</a>

                        </div>
                        <hr>

                        <div class="ps-3 p-3">
                            <div class="mb-3">
                                <label class="form-label" for="comment_status">کامنت</label>
                                <select class="form-select" name="comment_status" id="comment_status"
                                        form="create-item">
                                    <option value="1" {{old('comment_status') ? 1 : 'selected'}}>باز</option>
                                    <option value="0" {{old('comment_status') ? 0 : 'selected'}}>بسته</option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="form-select" id="status" name="status" form="create-item">
                                    <option
                                        value="public" {{old('status') ? "public" : 'selected'}}>
                                        منتشر
                                        شده
                                    </option>
                                    <option value="draft" {{old('status') ? "draft" : 'selected'}}>
                                        پیشنویس
                                    </option>
                                    <option value="hidden" {{old('status') ? "hidden" : 'selected'}}>
                                        پنهان
                                    </option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="slug">آدرس</label>
                                <input type="text" id="slug" name="slug" class="form-control" form="create-item"
                                       value="{{ old('slug')}}">
                            </div>

                            <div class="my-3">
                                <label class="form-label" for="spot_player_key">کلید اسپات پلیر</label>
                                <input type="text" id="spot_player_key" name="spot_player_key" class="form-control" form="create-item"
                                       value="{{ old('spot_player_key')}}" dir="ltr">
                            </div>

                            <div class="my-3">
                                <label for="short-description" class="form-label">توضیح کوتاه</label>
                                <textarea class="form-control" rows="8" name="short_description" id="short_description" form="create-item"></textarea>
                            </div>

                            <div class="my-3">
                                <label for="image_label" class="form-label">تصویر اصلی</label>
                                <div class="input-group">
                                    <input type="text" id="image_label" class="form-control" name="image"
                                           aria-label="Image" aria-describedby="button-image" form="create-item"
                                           value="{{ old('image') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-image">
                                            انتخاب
                                        </button>
                                    </div>
                                </div>
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
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date-picker").persianDatepicker({
                initialValue: false,
                format: 'YYYY/MM/DD HH:mm:ss',
                minDate: new persianDate(),
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
