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
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-3">
                <form action="{{ route('admin.joboffers.update', $joboffer) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">عنوان</label>
                                    <input type="text" value="{{ $joboffer->title }}" id="title" name="title"
                                           class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="select2Primary" class="form-check-label">دسته بندی</label>
                                    <div class="select2-primary">
                                        <select id="select2Primary" class="select2 form-select" name="categories[]" multiple>
                                            @foreach($categories as $c)
                                                <option
                                                    value="{{ $c->id }}" {{ $joboffer->categories->contains($c) ? 'selected' : '' }}>{{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="type">نوع</label>
                                    <input class="form-control" type="text" value="{{ $joboffer->type }}" id="type"
                                           name="type">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status">وضعیت</label>
                                    <select class="form-select" id="status" name="status">
                                        <option
                                            value="inactive" {{ $joboffer->status == 'inactive' ? 'selected' : '' }}>غیر
                                            فعال
                                        </option>
                                        <option value="active" {{ $joboffer->status == 'active' ? 'selected' : '' }}>
                                            فعال
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="row g-3">
                                    <label for="adminEditor" class="form-label">محتوا</label>
                                    <textarea id="adminEditor" name="content">{{ $joboffer->content }}</textarea>
                                </div>
                            </div>
                            <div class="pt-4 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">ویرایش</button>
                                @can('delete-job-offers')
                                    <x-admin::deletebutton/>
                                @endcan
                            </div>
                        </div>
                    </div>
                </form>
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
                    <form id="deleteForm" action="{{ route("admin.joboffers.destroy", $joboffer) }}" method="POST">
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
