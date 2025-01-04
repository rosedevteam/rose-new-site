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
                                <div class="col-md-2 mt-4 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">تغییر</button>
                                    @can('delete-job-applications')
                                        <x-admin::deletebutton/>
                                    @endcan
                                </div>
                            </div>
                        </form>
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
                        <form id="deleteForm" action="{{ route("admin.jobapplications.destroy", $jobapplication) }}"
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
@endsection
