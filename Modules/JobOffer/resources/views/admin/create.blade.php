@extends('admin::layouts.main')

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
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="category_id">تیم</label>
                                    <select class="form-select" name="category_id" id="category_id">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="type">نوع</label>
                                    <input class="form-control" type="text" id="type" name="type">
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
                                    <textarea id="adminEditor" name="content"></textarea>
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
@endpush
