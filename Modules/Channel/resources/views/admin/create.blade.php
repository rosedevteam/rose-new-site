@extends('admin::layouts.main')

@push('css')
    <link rel="stylesheet" href="/assets/admin/vendor/libs/select2/select2.css">
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4">

                <!-- User Sidebar -->
                <div class="col-md-12 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-header heading-color">مشخصات کانال</h5>
                            <form action="{{route('admin.channels.store')}}" method="post" id="createItem"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">نام کانال</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   id="title"
                                                   name="title"
                                                   value="{{old('title')}}"
                                                   placeholder="نام کانال">
                                            @error('title')
                                            <div class="invalid-feedback">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">توضیحات کانال</label>
                                            <input type="text"
                                                   class="form-control @error('description') is-invalid @enderror"
                                                   id="description"
                                                   name="description"
                                                   value="{{old('description')}}"
                                                   placeholder="توضیحات کانال">
                                            @error('description')
                                            <div class="invalid-feedback">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">آواتار کانال</label>
                                            <input class="form-control @error('avatar') is-invalid @enderror"
                                                   type="file"
                                                   id="avatar"
                                                   name="avatar"
                                                   value="{{old('avatar')}}">
                                            @error('avatar')
                                            <div class="invalid-feedback">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="products" class="form-label">برای</label>
                                        <div class="select2-primary">
                                            <select id="products" name="products[]" class="select2 @error('userLimit') is-invalid @enderror
                                     form-select" multiple>
                                                <option value="all">همه کاربران عضو کانال شوند</option>
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{$product->title}}
                                                        | {{$product->orders_count}}
                                                        سفارش موفق
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('userLimit')
                                            <div class="invalid-feedback">
                                                <span>{{$message}}</span>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">ایمپورت پیام ها از فایل
                                                JSON</label>
                                            <input class="form-control @error('json') is-invalid @enderror"
                                                   type="file"
                                                   id="json"
                                                   name="json"
                                                   value="{{old('json')}}">
                                        </div>
                                        @error('import')
                                        <div class="invalid-feedback">
                                            <span>{{$message}}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-next">
                                            <span class="d-sm-inline-block d-none me-sm-1">ایجاد کانال</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /User Card -->

                </div>
                <!--/ User Sidebar -->
            </div>
        </div>
    </div>
@stop

@push('script')
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/js/channel/create.js"></script>
@endpush
