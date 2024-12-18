@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom mx-3">
                    رزومه
                </div>
                <div class="card-content mx-5 my-5">
                    <div class="row justify-content-start">
                        <div class="col mx-2 mb-2"> نام و نام خانوادگی:
                            {{ $jobapplication->full_name }}
                        </div>
                        <div class="row mx-2 my-2">ایمیل:
                            {{ $jobapplication->email }}
                        </div>
                        <div class="row mx-2 my-2">شماره:
                            {{ $jobapplication->phone }}
                        </div>
                        <div class="row mx-2 my-2">رزومه:
                            {{ $jobapplication->resume }}
                        </div>
                        <div class="row mx-2 my-2">توضیحات:
                            {{ $jobapplication->description }}
                        </div>
                        <form action="{{ route("admin.jobapplications.update", $jobapplication) }}"
                              method="POST">
                            <div class="row mt-4">
                                @method("PATCH")
                                @csrf
                                <div class="col-md-2">
                                    <label for="status" class="form-label">وضعیت</label>
                                    <select class="form-select" id="status" name="status">
                                        <option
                                            value="accepted" {{ $jobapplication->status == "accepted" ? "selected" : "" }}>
                                            تایید شده
                                        </option>
                                        <option
                                            value="pending" {{ $jobapplication->status == "pending" ? "selected" : "" }}>
                                            در حال بررسی
                                        </option>
                                        <option
                                            value="rejected" {{ $jobapplication->status == "rejected" ? "selected" : "" }}>
                                            رد شده
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary">تغییر</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
