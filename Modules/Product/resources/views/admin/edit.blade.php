@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/vendor/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/tagify/tagify.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="/assets/admin/vendor/libs/typeahead-js/typeahead.css">
@endpush

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-8">
                    <h3>ویرایش محصول {{$product->title}}</h3>
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

                        <form action="{{ route('admin.products.update' , $product) }}" method="post" id="edit-item"
                              enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label" for="title">نام</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                   value="{{$product->title}}">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="adminEditor" class="form-label">محتوا</label>
                                        <textarea id="adminEditor" name="content">{{$product->content}}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="form-tabs-price" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label" for="is_free">محصول رایگان است؟</label>
                                            <select name="is_free" id="is_free" class="form-select">
                                                <option value="0" @if($product->is_free == 0) selected @endif>خیر
                                                </option>
                                                <option value="1" @if($product->is_free == 1) selected @endif>بله
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="price">قیمت عادی</label>
                                            <input type="text" id="price" name="price" class="form-control text-start"
                                                   dir="ltr" value="{{$product->price}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="sale_price">قیمت فروش ویژه</label>
                                            <input type="text" id="sale_price" name="sale_price" class="form-control"
                                                   value="{{$product->sale_price}}">
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">عنوان</label>
                                            <input type="text" id="title" name="meta_title"
                                                   class="form-control text-start"
                                                   value="{{ $product->metadata?->title }}" dir="ltr">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="keywords">کلمات کلیدی</label>
                                            <input type="text" id="keywords" name="meta_keywords" class="form-control"
                                                   value="{{ $product->metadata?->keywords }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label" for="description">توضیحات</label>
                                        <textarea id="description" class="form-control"
                                                  name="meta_description">{{ $product->metadata?->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-5 current-attrs">ویژگی های فعلی</h4>
                            <form action="{{route('admin.attributes.update')}}" method="post"
                                  enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                @foreach($product->attributes as $attr)

                                    <div class="row attribute-container">
                                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                            <label class="form-label">عنوان</label>
                                            <input type="text" name="attributes[{{$attr->id}}][title]"
                                                   class="form-control text-start" value="{{$attr->title}}"
                                                   placeholder="">
                                        </div>
                                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                            <label class="form-label">توضیحات</label>
                                            <input type="text" name="attributes[{{$attr->id}}][subtitle]"
                                                   class="form-control text-start" value="{{$attr->subtitle}}"
                                                   placeholder="">
                                        </div>
                                        <div class="mb-3 col-lg-3 col-12 mb-0">
                                            <label for="image_label" class="form-label"> آیکون</label>
                                            <input type="file" name="attributes[{{$attr->id}}][icon]"
                                                   value="{{$attr->icon}}"
                                                   class="form-control">
                                        </div>
                                        <div
                                            class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                            <a class="btn btn-label-danger mt-4"
                                               onclick="removeProductAttr({{$attr->id}} , $(this));">
                                                <i class="bx bx-x me-1"></i>
                                                <span class="align-middle">حذف</span>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>

                                @endforeach
                                @if($product->attributes->count())
                                    <button type="submit" class="btn btn-success">
                                        <span class="align-middle">بروزرسانی</span>
                                    </button>
                                @else
                                    <p>ویژگی ای وجود ندارد</p>
                                @endif

                            </form>
                            <form class="form-repeater">
                                <h4 class="mt-5 current-attrs">ویژگی جدید</h4>

                                <div data-repeater-list="attributes" class="new-attrs">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">عنوان</label>
                                                <input type="text" name="attr_title"
                                                       class="form-control text-start" placeholder="" form="edit-item">
                                            </div>
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">توضیحات</label>
                                                <input type="text" name="attr_subtitle"
                                                       class="form-control text-start" placeholder="" form="edit-item">
                                            </div>
                                            <div class="mb-3 col-lg-3 col-12 mb-0">
                                                <label for="image_label" class="form-label"> آیکون</label>
                                                <input type="file" name="icon" id="icon" class="form-control"
                                                       form="edit-item">
                                            </div>
                                            <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                    <i class="bx bx-x me-1"></i>
                                                    <span class="align-middle">حذف</span>
                                                </button>
                                            </div>
                                        </div>

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

                    <div class="card mt-3" @if($product->lessons->count() == 0) style="display: none"
                         @endif id="lessons-wrapper">
                        <div class="card-body">
                            <h4 class="mt-5 current-attrs">دروس فعلی</h4>
                            <form action="{{route('admin.lessons.update')}}" method="post"
                                  enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                @foreach($product->lessons as $lesson)

                                    <div class="row lesson-container">
                                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                            <label class="form-label">عنوان</label>
                                            <input type="text" name="lessons[{{$lesson->id}}][title]"
                                                   class="form-control text-start" value="{{$lesson->title}}"
                                                   placeholder="">
                                        </div>
                                        <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                            <label class="form-label">طول ویدیو</label>
                                            <input type="text" name="lessons[{{$lesson->id}}][duration]"
                                                   class="form-control text-start" value="{{$lesson->duration}}"
                                                   placeholder="">
                                        </div>
                                        <div class="mb-3 col-lg-3 col-12 mb-0">
                                            <label for="image_label" class="form-label"> فایل</label>
                                            <input type="text" name="lessons[{{$lesson->id}}][file]"
                                                   value="{{$lesson->file}}"
                                                   class="form-control">
                                        </div>
                                        <div
                                            class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                            <a class="btn btn-label-danger mt-4"
                                               onclick="removeProductLesson({{$lesson->id}} , $(this));">
                                                <i class="bx bx-x me-1"></i>
                                                <span class="align-middle">حذف</span>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>

                                @endforeach
                                @if($product->lessons->count())
                                    <button type="submit" class="btn btn-success">
                                        <span class="align-middle">بروزرسانی</span>
                                    </button>
                                @else
                                    <p>ویژگی ای وجود ندارد</p>
                                @endif

                            </form>
                            <form class="form-repeater-lessons">
                                <h4 class="mt-5 current-attrs">درس جدید</h4>

                                <div data-repeater-list="lessons">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">عنوان</label>
                                                <input type="text" name="lesson_title"
                                                       class="form-control text-start" placeholder="" form="edit-item">
                                            </div>
                                            <div class="mb-3 col-lg-6 col-xl-3 col-12 mb-0">
                                                <label class="form-label">توضیحات</label>
                                                <input type="text" name="lesson_duration"
                                                       class="form-control text-start" placeholder="" form="edit-item">
                                            </div>
                                            <div class="mb-3 col-lg-3 col-12 mb-0">
                                                <label for="image_label" class="form-label"> فایل</label>
                                                <input type="text" name="lesson_file" id="lesson_file"
                                                       class="form-control"
                                                       form="edit-item">
                                            </div>
                                            <div class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                    <i class="bx bx-x me-1"></i>
                                                    <span class="align-middle">حذف</span>
                                                </button>
                                            </div>
                                        </div>

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
                            <a href="{{route('admin.products.index')}}">بازگشت</a>

                        </div>
                        <hr>

                        <div class="ps-3 p-3">
                            <div class="mb-3">

                                @if(!$product->pagebuilder)
                                    <form action="{{route('admin.pagebuilder.create')}}" method="get">
                                        @method('get')
                                        <input type="hidden" name="pagebuilder_type" value="{{get_class($product)}}">
                                        <input type="hidden" name="pagebuilder_id" value="{{$product->id}}">
                                        <input type="submit" class="btn btn-primary w-100" value="ساخت صفحه با ویرایشگر زنده">
                                    </form>
                                @else
                                    <a href="{{route('admin.pagebuilder.edit' , $product->pagebuilder)}}"
                                       class="btn btn-primary w-100">ویرایشگر زنده</a>
                                @endif

                                {{--                                @dd($product->pagebuilder)--}}

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="comment_status">کامنت</label>
                                <select class="form-select" name="comment_status" id="comment_status"
                                        form="edit-item">
                                    <option value="1" {{$product->comment_status ? 1 : 'selected'}}>باز</option>
                                    <option value="0" {{$product->comment_status ? 0 : 'selected'}}>بسته</option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="form-select" id="status" name="status" form="edit-item">
                                    <option
                                        value="public" {{$product->status == 'public' ?  "selected" : '' }}>
                                        منتشر
                                        شده
                                    </option>
                                    <option value="draft" {{$product->status == "draft" ? 'selected' : ''}}>
                                        پیشنویس
                                    </option>
                                    <option value="outofstock" {{$product->status == "outofstock" ? 'selected' : ''}}>
                                        ناموجود
                                    </option>
                                    <option value="hidden" {{$product->status == "hidden" ? 'selected' : ''}}>
                                        پنهان
                                    </option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="slug">آدرس</label>
                                <input type="text" id="slug" name="slug" class="form-control" form="edit-item"
                                       value="{{$product->slug}}">
                            </div>

                            <div class="my-3">
                                <label for="select2Primary" class="form-check-label">دسته بندی</label>
                                <div class="select2-primary">
                                    <select id="select2Primary" class="select2 form-select" name="categories[]"
                                            form="edit-item" multiple>
                                        @foreach($categories as $c)
                                            <option
                                                value="{{ $c->id }}" {{ $product->categories->contains($c) ? 'selected' : '' }}>{{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="my-3">
                                <label class="form-label" for="spot_player_key">کلید اسپات پلیر</label>
                                <input type="text" id="spot_player_key" name="spot_player_key" class="form-control"
                                       form="edit-item"
                                       value="{{$product->spot_player_key}}" dir="ltr">
                            </div>

                            <div class="my-3">
                                <label class="form-label" for="duration">مدت زمان دوره</label>
                                <input type="text" id="duration" name="duration" class="form-control"
                                       form="create-item"
                                       value="{{$product->duration}}">
                            </div>

                            <div class="my-3">
                                <label for="short-description" class="form-label">توضیح کوتاه</label>
                                <textarea class="form-control" rows="8" name="short_description" id="short_description"
                                          form="edit-item">{{$product->short_description}}</textarea>
                            </div>

                            <div class="my-3">
                                <label for="image_label" class="form-label">تصویر اصلی</label>
                                <div class="input-group">
                                    <input type="text" id="image_label" class="form-control" name="image"
                                           aria-label="Image" aria-describedby="button-image" form="edit-item"
                                           value="{{$product->image}}">
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
                                <button type="submit" class="btn btn-sm btn-primary " form="edit-item">بروز رسانی
                                </button>
                                @can('delete-products')
                                    <x-admin::deletebutton/>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center mb-4 mt-0 mt-md-n2">
                                <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                            </div>
                            <form id="deleteForm" action="{{ route("admin.products.destroy", $product) }}"
                                  method="POST">
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

@push('script')
    <x-admin::tinymce/>
    <x-admin::filemanager-btn/>
    <script src="/assets/admin/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="/assets/vendor/sweetalert/sweetalert2.js"></script>
    <script src="/assets/admin/js/products/edit.js"></script>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/tagify/tagify.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="/assets/admin/vendor/libs/bootstrap-select/i18n/defaults-fa_ir.js"></script>
    <script src="/assets/admin/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="/assets/admin/vendor/libs/bloodhound/bloodhound.js"></script>
    <script src="/assets/admin/js/main.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
    <script src="/assets/admin/js/forms-tagify.js"></script>
    <script src="/assets/admin/js/forms-typeahead.js"></script>
@endpush
