@extends('admin::layouts.main')

@section('title')
    {{ $jobOffer->title }}
@endsection

@section('content')

    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-3">
                <form action="{{ route('admin.joboffer.update', $jobOffer) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">عنوان</label>
                                    <input type="text" value="{{ $jobOffer->title }}" id="title" name="title" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="team">تیم</label>
                                    <select class="form-select" name="team" id="team">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $jobOffer->categories()->first()->id ? 'selected' : '' }}>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="type">نوع</label>
                                    <input class="form-control" type="text" value="{{ $jobOffer->type }}" id="type" name="type">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status">وضعیت</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="inactive" {{ $jobOffer->status == 'inactive' ? 'selected' : '' }}>غیر فعال</option>
                                        <option value="active" {{ $jobOffer->status == 'active' ? 'selected' : '' }}>فعال</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="row g-3">
                                    <label for="adminEditor" class="form-label">محتوا</label>
                                    <textarea id="adminEditor" name="content">{{ $jobOffer->content }}</textarea>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">ویرایش</button>
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
