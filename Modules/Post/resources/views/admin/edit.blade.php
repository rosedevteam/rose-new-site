@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/css/file-manager.css">
    <script src="/assets/admin/js/file-manager.js"></script>
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
                    <h3>ویرایش آیتم "{{$post->title}}"</h3>
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
                                        سئو
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.posts.update', $post) }}" method="POST" id="edit-item">
                            @method('PATCH')
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label" for="title">نام</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                   value="{{ $post->title }}">
                                        </div>

                                    </div>
                                    <div class="row g-3 mb-4">

                                    </div>
                                    <div class="row g-3">
                                        <label for="adminEditor" class="form-label">محتوا</label>
                                        <textarea id="adminEditor" name="content">{{ $post->content }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="title">عنوان</label>
                                            <input type="text" id="title" name="meta_title"
                                                   class="form-control text-start"
                                                   value="{{ $post->metadata?->title }}" dir="ltr">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="keywords">کلمات کلیدی</label>
                                            <input type="text" id="keywords" name="meta_keywords" class="form-control"
                                                   value="{{ $post->metadata?->keywords }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label" for="description">توضیحات</label>
                                        <textarea id="description" class="form-control"
                                                  name="meta_description">{{ $post->metadata?->description }}</textarea>
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
                                <select class="form-select" name="comment_status" id="comment_status" form="edit-item">
                                    <option value="1" {{ $post->comment_status == 1 ? 'selected' : '' }}>باز
                                    </option>
                                    <option value="0"{{ $post->comment_status == 0 ? 'selected' : '' }}>بسته
                                    </option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="form-select" id="status" name="status" form="edit-item">
                                    <option
                                        value="public" {{ $post->status == 'public' ? 'selected' : '' }}>
                                        منتشر
                                        شده
                                    </option>
                                    <option value="draft"{{ $post->status == 'draft' ? 'selected' : '' }}>
                                        پیشنویس
                                    </option>
                                    <option value="hidden"{{ $post->status == 'hidden' ? 'selected' : '' }}>
                                        پنهان
                                    </option>
                                </select>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="slug">آدرس</label>
                                <input type="text" id="slug" name="slug" class="form-control" form="edit-item"
                                       value="{{ $post->slug }}">
                            </div>

                            <div class="my-3">
                                <label for="image_label">تصویر اصلی</label>
                                <div class="input-group">
                                    <input type="text" id="image_label" class="form-control" name="image"
                                           aria-label="Image" aria-describedby="button-image" form="edit-item"
                                           value="{{$post->image}}">
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
                                    <select id="select2Primary" class="select2 form-select" name="categories[]"
                                            form="edit-item" multiple required>
                                        @foreach($categories as $c)
                                            <option
                                                value="{{ $c->id }}" {{ $post->categories->contains($c) ? 'selected' : '' }}>{{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pt-4 d-flex align-items-center justify-content-between">
                                <button type="submit" class="btn btn-sm btn-primary " form="edit-item">بروز رسانی
                                </button>
                                <a class="btn btn-sm btn-info " href="{{url('/') . '/posts/' . $post->slug}}">مشاهده
                                    آیتم</a>
                                @can('delete-posts')
                                    <x-admin::deletebutton/>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="ps-3 p-3 d-flex align-items-center justify-content-between">
                            <h5>تصویر فعلی</h5>
                        </div>
                        <hr>
                        <div class="ps-3 pe-3">
                            @if(!is_null($post->image))
                                <img src="{{$post->image}}" alt="" class="br-3">
                            @else
                                <div class="alert alert-warning" role="alert">آیتم فاقد تصویر میباشد</div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mb-4 mt-0 mt-md-n2">
                        <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                    </div>
                    <form id="deleteForm" action="{{ route("admin.posts.destroy", $post) }}" method="POST">
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
@endsection

@push('script')
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
