@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="flex-grow-1 p-3y">
            {{$subs->appends(['search' => request('search'),])}}
            <!-- subs List Table -->
            <div class="card mx-4">
                <div class="row p-3">
                    <div class="d-flex align-items-center justify-content-between">

                        @can('manage-subscriptions')
                            <button data-bs-toggle="modal"
                                    data-bs-target="#modalCenter"
                                    class="btn btn-secondary create-new btn-primary ms-2"
                                    type="button">
                    <span><i class="bx bx-plus me-sm-1"></i> <span
                            class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></button>
                        @endcan

                        <!-- Modal Create -->
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title secondary-font" id="modalCenterTitle">افزودن رکورد
                                            جدید</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form id="createNewItem" method="post">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="name" class="form-label">نام</label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                           placeholder="نام را وارد کنید" value="{{old('name')}}">
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <label for="description" class="form-label">توضیحات</label>
                                                <textarea name="description" id="description" cols="30" rows="10"
                                                          class="form-control"></textarea>
                                            </div>
                                            <div class="row g-2">
                                                <label for="expire_date" class="form-label my-2"> تاریخ انقضا </label>
                                                <input type="text" name="expire_date" class="form-control mb-2"
                                                       id="expire_date" autocomplete="off"
                                                       placeholder="تاریخ انقضا" required>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal">
                                                بستن
                                            </button>
                                            <button type="button" class="btn btn-primary" onclick="createItem()">
                                                افزودن
                                            </button>
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
                                                    <label for="nameEdit" class="form-label">نام</label>
                                                    <input type="text" name="nameEdit" id="nameEdit"
                                                           class="form-control"
                                                           placeholder="نام را وارد کنید" value="{{old('nameEdit')}}">
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <label for="descriptionEdit" class="form-label">توضیحات</label>
                                                <textarea name="descriptionEdit" id="descriptionEdit" cols="30"
                                                          rows="10" class="form-control"></textarea>
                                            </div>
                                            <div class="row g-2">
                                                <label for="expire_dateEdit" class=" my-2"> تاریخ انقضا </label>
                                                <input type="text" name="expire_dateEdit" class="form-control mb-2"
                                                       id="expire_dateEdit" autocomplete="off"
                                                       placeholder="تاریخ انقضا" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal">
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
                                <button class="btn btn-icon btn-primary ms-2" type="button" id="search-submit">
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
                            <th>نام</th>
                            <th>توضیحات</th>
                            <th>تاریخ انقضا</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody id="subs-list">
                        @foreach($subs as $sub)

                            <tr>
                                <td>{{$sub->name}}</td>
                                <td>{{$sub->description}}</td>
                                <td>{{\Hekmatinasser\Verta\Verta::instance($sub->expire_date)->formatJalaliDate()}}</td>
                                @can('manage-subscriptions')
                                    <td>
                                        <button data-bs-toggle="modal"
                                                data-bs-target="#modalEdit"
                                                type="button"
                                                onclick="editItem({{$sub->id}})"
                                                class="btn btn-sm btn-info item-edit">
                                            ویرایش
                                        </button>

                                        <div class="btn-group">
                                            <form action="{{route('admin.subscriptions.destroy' , $sub)}}"
                                                  id="deleteItem-{{$sub->id}}" method="post">
                                                @method('delete')
                                                @csrf
                                            </form>
                                            <button
                                                onclick="document.querySelector('#deleteItem-{{$sub->id}}').submit()"
                                                class="btn btn-sm btn-danger" id="removeItem">
                                                حذف
                                            </button>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
            {{$subs->appends(['search' => request('search'),])}}
        </div>
    </div>
@stop

@section('scripts')
    {{--    todo fix datepicker--}}
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script src="/admin/assets/js/axios.js"></script>
    <script src="/admin/assets/js/subs/subs.js"></script>
@stop
