@extends('admin::layouts.main')

@section('head')
    <link rel="stylesheet" href="/assets/admin/js/persian-date/persian-datepicker.min.css">
@stop

@section('content')
    {{$telegrams->appends(['search' => request('search'),  'export' => request('export'),'filter' => request('filter') , 'is_notified' => request('is_notified'), 'is_deleted' => request('is_deleted')])}}
    <!-- subs List Table -->
    <div class="card mb-4">
        <div class="row p-3">
            <div class="d-flex align-items-center justify-content-between">

                @can('manage-subscriptions')
                    <div class="d-flex align-items-center justify-content-between">
                        @can('manage-subscriptions')
                            <button data-bs-toggle="modal"
                                    data-bs-target="#modalCenter"
                                    class="btn btn-secondary create-new btn-primary ms-2"
                                    type="button">
                    <span><i class="bx bx-plus me-sm-1"></i> <span
                            class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></button>
                        @endcan
                        <a class="btn btn-secondary ms-2" data-bs-toggle="offcanvas" href="#filters" role="button"
                           aria-controls="filters">
                            <i class="bx bx-filter me-sm-1"></i>
                            فیلتر ها
                        </a>
                        <a class="btn btn-info ms-2 text-white"
                           onclick="document.querySelector('#export').value = 1; document.querySelector('#filters-form').submit();"
                           download>
                            <i class="bx bx-download me-sm-1"></i>
                            اکسپورت
                        </a>
                        <span class="ms-4">{{number_format($telegrams->total())}}
                        عضو</span>
                        {{--                        <span class="ms-4">{{number_format($deleted)}}--}}
                        {{--                        حذف شده</span>--}}
                    </div>

                @endcan

                <!-- Modal Create -->
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title secondary-font" id="modalCenterTitle">افزودن رکورد جدید</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form id="createNewItem" method="post">
                                @csrf
                                @method('post')
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="fullname" class="form-label">نام و نام خانوادگی</label>
                                            <input type="text" name="fullname" id="fullname" class="form-control"
                                                   placeholder="نام و نام خانوادگی را وارد کنید"
                                                   value="{{old('fullname')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label for="phone" class="form-label">موبایل</label>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                   placeholder="موبایل" value="{{old('phone')}}">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="telegram_id" class="form-label">آیدی</label>
                                            <input type="text" name="telegram_id" id="telegram_id" class="form-control"
                                                   placeholder="آیدی تلگرام" value="{{old('telegram_id')}}">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="duration" class="form-label">مدت زمان</label>
                                            <input type="text" name="duration" id="duration" class="form-control"
                                                   placeholder="مدت زمان" value="{{old('duration')}}">
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <label for="desc" class="form-label">توضیحات</label>
                                        <textarea name="desc" id="desc" cols="30" rows="5"
                                                  class="form-control"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="start_date" class="form-label my-2"> تاریخ شروع </label>
                                            <input type="text" name="start_date" class="form-control mb-2"
                                                   id="start_date"
                                                   autocomplete="off"
                                                   placeholder="تاریخ شروع" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="end_date" class="form-label my-2"> تاریخ پایان </label>
                                            <input type="text" name="end_date" class="form-control mb-2" id="end_date"
                                                   autocomplete="off"
                                                   placeholder="تاریخ پایان" required>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                        بستن
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="createItem()">افزودن</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title secondary-font" id="modalCenterTitle">ویرایش</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form id="EditProduct">
                                <div class="modal-body">
                                    <input type="hidden" id="edit-item-id">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="fullnameEdit" class="form-label">نام و نام خانوادگی</label>
                                            <input type="text" name="fullnameEdit" id="fullnameEdit"
                                                   class="form-control"
                                                   placeholder="نام و نام خانوادگی را وارد کنید"
                                                   value="{{old('fullnameEdit')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label for="phoneEdit" class="form-label">موبایل</label>
                                            <input type="text" name="phoneEdit" id="phoneEdit" class="form-control"
                                                   placeholder="موبایل" value="{{old('phoneEdit')}}">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="telegram_idEdit" class="form-label">آیدی</label>
                                            <input type="text" name="telegram_idEdit" id="telegram_idEdit"
                                                   class="form-control"
                                                   placeholder="آیدی تلگرام" value="{{old('telegram_idEdit')}}">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label for="durationEdit" class="form-label">مدت زمان</label>
                                            <input type="text" name="durationEdit" id="durationEdit"
                                                   class="form-control"
                                                   placeholder="مدت زمان" value="{{old('durationEdit')}}">
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <label for="descEdit" class="form-label">توضیحات</label>
                                        <textarea name="descEdit" id="descEdit" cols="30" rows="5"
                                                  class="form-control"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="start_dateEdit" class="form-label my-2"> تاریخ شروع </label>
                                            <input type="text" name="start_dateEdit" class="form-control mb-2"
                                                   id="start_dateEdit"
                                                   autocomplete="off"
                                                   placeholder="تاریخ شروع" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="end_dateEdit" class="form-label my-2"> تاریخ پایان </label>
                                            <input type="text" name="end_dateEdit" class="form-control mb-2"
                                                   id="end_dateEdit"
                                                   autocomplete="off"
                                                   placeholder="تاریخ پایان" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="is_notifiedEdit" class="form-label my-2"> اس ام اس یاد آوری </label>
                                        <select name="is_notifiedEdit" id="is_notifiedEdit" class="form-select">
                                            <option value="0">ارسال نشده</option>
                                            <option value="1">ارسال شده</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="is_deletedEdit" class="form-label my-2"> وضعیت </label>
                                        <select name="is_deleted" id="is_deletedEdit" class="form-select">
                                            <option value="1">حذف شده</option>
                                            <option value="0">عضو</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                        بستن
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="updateItem()">ویرایش
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <form action="" id="search">
                    <label class="d-flex align-items-center justify-content-between">
                        <input type="text" class="form-control"
                               placeholder="جستجو" id="search-key" name="search">
                        <button class="btn btn-icon btn-primary ms-2" type="submit" id="search-submit">
                            <span class="tf-icons bx bx-search"></span>
                        </button>
                    </label>
                </form>


            </div>

        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top">
                <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>آیدی تلگرام</th>
                    <th>مدت زمان</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th>اس ام اس یادآوری</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody id="tele-list">
                @foreach($telegrams as $telegram)

                    <tr>
                        <td>
                            <div class="d-flex flex-column">
                                <span>{{$telegram->fullname}}</span>
                                <small class="emp_post text-truncate text-muted">{{$telegram->phone}}</small>

                            </div>
                        </td>
                        <td>{{$telegram->telegram_id}}</td>
                        <td>{{$telegram->duration}}</td>
                        <td>{{\Hekmatinasser\Verta\Verta::instance($telegram->start_date)->formatJalaliDate()}}</td>
                        <td>{{\Hekmatinasser\Verta\Verta::instance($telegram->end_date)->formatJalaliDate()}}</td>
                        <td>
                            @switch($telegram->is_notified)
                                @case(1)
                                    <span class="badge bg-info">ارسال شده</span>
                                    @break
                                @case(0)
                                    <span class="badge bg-warning">ارسال نشده</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @switch($telegram->is_deleted)
                                @case(1)
                                    <div class="d-flex flex-column">
                                        <span class="badge bg-danger">حذف شده</span>
                                        <small class="emp_post text-truncate text-muted">
                                            تاریخ حذف:
                                            {{\Hekmatinasser\Verta\Verta::instance($telegram->deleted_date)->formatJalaliDate()}}
                                        </small>
                                    </div>

                                    @break
                                @case(0)
                                    <span class="badge bg-success">عضو</span>
                                    @break
                            @endswitch
                        </td>

                        <td>
                            @if(!is_null($user = \Modules\User\Models\User::where('phone' , 'like' , "%$telegram->phone%")->first()))
                                <a href="{{route('admin.users.edit' , $user)}}"
                                   class="ms-2 btn btn-sm btn-secondary" target="_blank">
                                    پروفایل
                                </a>
                            @endif
                            <button data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    type="button"
                                    onclick="editItem({{$telegram->id}})"
                                    class="btn btn-sm btn-info item-edit">
                                ویرایش
                            </button>
                            @can('edit-subscriptions')
                                <button class="btn btn-sm btn-danger"
                                        onclick="removeItem({{$telegram->id}} , $(this))"
                                        type="button">حذف
                                </button>

                                @if($telegram->desc)
                                    <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                            data-bs-original-title="{{$telegram->desc}}">
                                        توضیحات
                                    </button>
                                @endif
                            @endcan
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

    </div>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filters" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">فیلتر ها</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('admin.telegrams.index')}}" method="GET" id="filters-form">
                <input type="hidden" name="filter" id="filter" value="1">
                <input type="hidden" name="export" id="export" value="0">
                <div class="mb-3">
                    <label for="is_deleted" class="form-label-sm my-1">وضعیت</label>
                    <select class="form-select" name="is_deleted" id="is_deleted">
                        <option value="">انتخاب کنید</option>
                        <option value="0" @if(request('is_deleted') == 0) selected @endif>عضو</option>
                        <option value="1" @if(request('is_deleted') == 1) selected @endif>حذف شده</option>
                    </select>

                </div>

                <div class="mb-3">
                    <label for="is_notified" class="form-label-sm my-1">اس ام اس</label>
                    <select class="form-select" name="is_notified" id="is_notified">
                        <option value="">انتخاب کنید</option>
                        <option value="1" @if(request('is_notified') == 1) selected @endif>ارسال شده</option>
                        <option value="0" @if(request('is_notified') == 0) selected @endif>ارسال نشده</option>
                    </select>

                </div>

                <button class="btn btn-primary" onclick="document.querySelector('#export').value = 0">
                    فیلتر
                </button>
            </form>
        </div>
    </div>
    {{$telegrams->appends(['search' => request('search'),  'export' => request('export'),'filter' => request('filter') , 'is_notified' => request('is_notified'), 'is_deleted' => request('is_deleted')])}}
@stop

@push('vendor')
    <script src="/assets/admin/js/persian-date/persian-date.min.js"></script>
    <script src="/assets/admin/js/persian-date/persian-datepicker.min.js"></script>
    <script src="/assets/admin/js/axios.js"></script>
    <script src="/assets/admin/js/subs/telegram.js"></script>
@endpush
