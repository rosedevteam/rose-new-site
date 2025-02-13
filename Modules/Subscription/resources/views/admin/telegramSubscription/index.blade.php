@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="flex-grow-1 p-3y">
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
                                                <label for="duration" class="form-label"> مدت زمان (ماه)</label>
                                                <input type="number" name="duration" id="duration" class="form-control"
                                                       placeholder="مدت زمان اشتراک" value="{{old('duration')}}" >
                                            </div>
                                            <div class="row g-2">
                                                <label for="price" class="form-label">هزینه</label>
                                                <input type="text" name="price" id="price" class="form-control"
                                                       placeholder="هزینه اشتراک" value="{{old('price')}}">
                                            </div>
                                            <div class="row g-2">
                                                <label for="product_id" class="form-check-label">محصول</label>
                                                <div class="select2-primary">
                                                    <select id="product_id" class=" select-product form-select"
                                                            name="product_id">
                                                        @foreach(\Modules\Product\Models\Product::where('status' , 'public')->get() as $p)
                                                            <option
                                                                value="{{ $p->id }}">{{ $p->title}}</option>
                                                        @endforeach
                                                    </select>
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
                            <th>مدت زمان</th>
                            <th>قیمت</th>
                            <th>محصول</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody id="subs-list">
                        @foreach($subs as $sub)

                            <tr>
                                <td>{{$sub->name}}</td>
                                <td>{{$sub->duration}}</td>
                                <td>{{number_format($sub->price)}}</td>
                                <td>{{$sub->product->title}}</td>
                                @can('manage-subscriptions')
                                    <td>
                                        <button data-bs-toggle="modal"
                                                data-bs-target="#modalEdit-{{$sub->id}}"
                                                type="button"
                                                class="btn btn-sm btn-info item-edit">
                                            ویرایش
                                        </button>

                                        <div class="btn-group">
                                            <form action="{{route('admin.telegramSubscriptions.destroy' , $sub)}}"
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
                            <div class="modal fade" id="modalEdit-{{$sub->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title secondary-font" id="modalCenterTitle">ویرایش</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="{{route('admin.telegramSubscriptions.update' , $sub)}}">
                                            @method('patch')
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="edit-item-id">
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label for="name" class="form-label">نام</label>
                                                        <input type="text" name="name"
                                                               class="form-control"
                                                               placeholder="نام را وارد کنید" value="{{$sub->name}}">
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <label for="duration" class="form-label"> مدت زمان (ماه)</label>
                                                    <input type="number" name="duration"
                                                           class="form-control"
                                                           placeholder="" value="{{$sub->duration}}">
                                                </div>
                                                <div class="row g-2">
                                                    <label for="price" class="form-label">قیمت</label>
                                                    <input type="text" name="price"
                                                           class="form-control"
                                                           placeholder="" value="{{$sub->price}}">
                                                </div>
                                                <div class="row g-2">
                                                    <label for="product_id" class="form-check-label">محصول</label>
                                                    <div class="select2-primary">
                                                        <select class=" select-product form-select"
                                                                name="product_id">
                                                            @foreach(\Modules\Product\Models\Product::where('status' , 'public')->get() as $p)
                                                                <option
                                                                    value="{{ $p->id }}" @if($sub->product_id == $p->id) selected @endif>{{ $p->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-label-secondary"
                                                        data-bs-dismiss="modal">
                                                    بستن
                                                </button>
                                                <button type="submit" class="btn btn-primary">ویرایش
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        </tbody>
                    </table>
                    {{ $subs->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

@push('vendor')
    <script src="{{asset('assets/front/vendor/block-ui/block-ui.js')}}"></script>>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="/assets/admin/js/axios.js"></script>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/js/forms-selects.js"></script>
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script
    <script src="{{asset('assets/vendor/sweetalert/sweetalert2.js')}}"></script>
    <script src="/assets/admin/js/subs/subs.js"></script>
@endpush

