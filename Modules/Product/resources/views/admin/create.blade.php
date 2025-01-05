@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/vendor/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
@endpush

@section('content')

    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-8">
                    <h3>افزودن محصول جدید</h3>
                    <hr>
                    <div class="card mb-3">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-tabs card-header-tabs primary-font" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#form-tabs-post"
                                            role="tab" aria-selected="false" tabindex="-1">
                                        محتوا
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-price"
                                            role="tab"
                                            aria-selected="true">
                                        جزئیات قیمت
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-seo"
                                            role="tab"
                                            aria-selected="true">
                                        سئو
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.products.store') }}" method="post" id="create-item"
                              enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label" for="title">نام</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                   value="{{old('title')}}">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="adminEditor" class="form-label">محتوا</label>
                                        <textarea id="adminEditor" name="content">{{old('content')}}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="form-tabs-price" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label" for="is_free">محصول رایگان است؟</label>
                                            <select name="is_free" id="is_free" class="form-select">
                                                <option value="0" selected>خیر</option>
                                                <option value="1">بله</option>
                                            </select>
                                        </div>
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
                                <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">عنوان</label>
                                            <input type="text" id="title" name="meta_title"
                                                   class="form-control text-start" value="{{ old('meta_title') }}"
                                                   dir="ltr">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="keywords">کلمات کلیدی</label>
                                            <input type="text" id="keywords" name="meta_keywords" class="form-control"
                                                   value="{{ old('meta_keywords') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label" for="description">توضیحات</label>
                                        <textarea id="description" class="form-control"
                                                  name="meta_description">{{ old('meta_description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-5">ویژگی های محصول</h4>
                            <form class="form-repeater">
                                <div data-repeater-list="attributes">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">عنوان</label>
                                                <input type="text" name="attr_title"
                                                       class="form-control text-start" placeholder=""
                                                       form="create-item">
                                            </div>
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">توضیحات</label>
                                                <input type="text" name="attr_subtitle"
                                                       class="form-control text-start" placeholder=""
                                                       form="create-item">
                                            </div>
                                            <div class="mb-3 col-lg-3 col-12 mb-0">
                                                <label for="image_label" class="form-label"> آیکون</label>
                                                <input type="file" name="icon" id="icon" class="form-control"
                                                       form="create-item">
                                            </div>
                                            <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                    <i class="bx bx-x me-1"></i>
                                                    <span class="align-middle">حذف</span>
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <button class="btn btn-primary" data-repeater-create>
                                        <i class="bx bx-plus me-1"></i>
                                        <span class="align-middle">افزودن</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-3" id="lessons-wrapper" style="display: none">
                        <div class="card-body">
                            <div class="alert alert-primary" role="alert">
                                <h6 class="alert-heading mb-1">راهنما</h6>
                                <span>برای آپلود فایل میبایست از طریق فایل منیجر فایل مورد نظر را آپلود و آدرس را داخل فیلد آدرس فایل کپی نمایید</span>
                            </div>
                            <h4 class="mt-5">لیست دروس</h4>
                            <form class="form-repeater-lessons">
                                <div data-repeater-list="lessons">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">عنوان</label>
                                                <input type="text" name="lesson_title"
                                                       class="form-control text-start" placeholder=""
                                                       form="create-item">
                                            </div>
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">طول ویدیو</label>
                                                <input type="text" name="lesson_duration"
                                                       class="form-control text-start" placeholder=""
                                                       form="create-item">
                                            </div>
                                            <div class="mb-3 col-lg-3 col-12 mb-0">
                                                <label for="image_label" class="form-label"> آدرس فایل ویدیو</label>
                                                <input type="text" name="file" class="form-control" form="create-item">
                                            </div>
                                            <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                    <i class="bx bx-x me-1"></i>
                                                    <span class="align-middle">حذف</span>
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <button class="btn btn-primary" data-repeater-create>
                                        <i class="bx bx-plus me-1"></i>
                                        <span class="align-middle">افزودن</span>
                                    </button>
                                </div>
                            </form>
                        </div>
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
                                    <option value="outofstock" {{old('status') ? "outofstock" : 'selected'}}>
                                        ناموجود
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
                                <input type="text" id="spot_player_key" name="spot_player_key" class="form-control"
                                       form="create-item"
                                       value="{{ old('spot_player_key')}}" dir="ltr">
                            </div>

                            <div class="my-3">
                                <label class="form-label" for="duration">مدت زمان دوره</label>
                                <input type="text" id="duration" name="duration" class="form-control"
                                       form="create-item"
                                       value="{{ old('duration')}}">
                            </div>

                            <div class="my-3">
                                <label for="select2Primary" class="form-check-label">دسته بندی</label>
                                <div class="select2-primary">
                                    <select id="select2Primary" class="select2 form-select" name="categories[]"
                                            form="create-item" multiple>
                                        @foreach($categories as $c)
                                            <option
                                                value="{{ $c->id }}">{{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="my-3">
                                <label for="short-description" class="form-label">توضیح کوتاه</label>
                                <textarea class="form-control" rows="8" name="short_description" id="short_description"
                                          form="create-item"></textarea>
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

                            <div class="my-3">
                                <label for="image_label_1">فایل منیجر</label>
                                <div class="mb-3">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary w-100 mt-3" type="button"
                                                id="button-image-1">
                                            فایل منیجر
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

@push('script')
    <x-admin::tinymce/>
    <x-admin::filemanager-btn/>
    <script src="/assets/admin/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="/assets/admin/js/products/create.js"></script>
    <script src="/assets/vendor/sweetalert/sweetalert2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
@endpush
