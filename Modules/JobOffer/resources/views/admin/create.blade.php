@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
@endpush

@section('content')

    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-3">
                <form action="{{ route('admin.joboffers.store') }}" method="post">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">عنوان</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           value="{{ old('title') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="select2Primary" class="form-check-label">دسته بندی</label>
                                    <div class="select2-primary">
                                        <select id="select2Primary" class="select2 form-select" name="categories[]" multiple>
                                            @foreach($categories as $c)
                                                <option
                                                    value="{{ $c->id }}" {{ in_array($c->id, old('categories') ?: []) ? 'selected' : '' }}>{{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="type">نوع</label>
                                    <input class="form-control" type="text" id="type" name="type"
                                           value="{{ old('type') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status">وضعیت</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="active" selected>فعال</option>
                                        <option value="inactive" >غیر فعال</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="row g-3">
                                    <label for="adminEditor" class="form-label">محتوا</label>
                                    <textarea id="adminEditor" name="content">{{ old('content') }}</textarea>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">ثبت</button>
                                <button type="reset" class="btn btn-label-secondary">انصراف</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <x-admin::tinymce/>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
@endpush
