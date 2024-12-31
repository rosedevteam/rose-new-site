@extends('admin::layouts.main')


@push('css')
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
                    <h3>افزودن پست جدید</h3>
                    <hr>
                    <div class="card mb-3">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-tabs card-header-tabs primary-font" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#form-tabs-post"
                                            role="tab" aria-selected="false" tabindex="-1">
                                        پست
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-seo"
                                            role="tab"
                                            aria-selected="true">
                                        seo
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.posts.store') }}" method="post" id="create-item">
                            @method('post')
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label" for="title">نام</label>
                                            <input type="text" id="title" name="title" class="form-control" value="{{old('title')}}">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <label for="adminEditor" class="form-label">محتوا</label>
                                        <textarea id="adminEditor" name="content">{{old('content')}}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="formtabs-username">نام کاربری</label>
                                            <input type="text" id="formtabs-username" class="form-control text-start"
                                                   placeholder="john.doe" dir="ltr">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="formtabs-email">ایمیل</label>
                                            <div class="input-group input-group-merge">
                                            <span class="input-group-text" id="formtabs-email2"
                                                  dir="ltr">@example.com</span>
                                                <input type="text" id="formtabs-email" class="form-control text-start"
                                                       placeholder="john.doe" aria-label="john.doe"
                                                       aria-describedby="formtabs-email2" dir="ltr">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-password-toggle">
                                                <label class="form-label" for="formtabs-password">رمز عبور</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="formtabs-password"
                                                           class="form-control text-start" placeholder="············"
                                                           dir="ltr" aria-describedby="formtabs-password2">
                                                    <span class="input-group-text cursor-pointer"
                                                          id="formtabs-password2"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-password-toggle">
                                                <label class="form-label" for="formtabs-confirm-password">تایید رمز
                                                    عبور</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="formtabs-confirm-password"
                                                           class="form-control text-start" placeholder="············"
                                                           dir="ltr" aria-describedby="formtabs-confirm-password2">
                                                    <span class="input-group-text cursor-pointer"
                                                          id="formtabs-confirm-password2"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                            </div>
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
                                <label for="image_label">تصویر اصلی</label>
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
                                <label for="select2Primary" class="form-check-label">دسته بندی</label>
                                <div class="select2-primary">
                                    <select id="select2Primary" class="select2 form-select" name="categories[]" form="create-item" multiple>
                                        <option value="" type="hidden" selected></option>
                                        @foreach($categories as $c)
                                            <option
                                                value="{{ $c->id }}">{{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}</option>
                                        @endforeach
                                    </select>
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
    <x-admin::tinymce/>
    <x-admin::filemanager-btn/>
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
