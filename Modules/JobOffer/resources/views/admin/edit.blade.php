@extends('admin::layouts.main')

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
                                <div class="col-md-3">
                                    <label class="form-label" for="category_id">تیم</label>
                                    <select class="form-select" name="category_id" id="category_id">
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category->id }}" {{ $category->id == $joboffer->category->id ? 'selected' : '' }}>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">ویرایش</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mx-4 mb-2">
                    @can('delete-job-offers')
                        <x-admin::deletebutton data-id="{{ $joboffer->id }}"/>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
@endpush
