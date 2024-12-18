@extends('admin::layouts.main')


@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-3">
                <div class="card-header border-bottom">
                    <ul class="nav nav-tabs card-header-tabs primary-font" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-post"
                                    role="tab" aria-selected="false" tabindex="-1">
                                پست
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-seo" role="tab"
                                    aria-selected="true">
                                seo
                            </button>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('admin.posts.store') }}" method="post">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="form-tabs-post" role="tabpanel">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">نام</label>
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="url">آدرس</label>
                                    <input type="text" id="url" name="url" class="form-control">
                                </div>
                            </div>
                            <div class="row g-3">
                                <label for="adminEditor" class="form-label">محتوا</label>
                                <textarea id="adminEditor" name="content"></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="formtabs-username">نام کاربری</label>
                                    <input type="text" id="formtabs-username" class="form-control text-start"
                                           placeholder="john.doe" dir="ltr">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="formtabs-email">ایمیل</label>
                                    <div class="input-group input-group-merge">
                                            <span class="input-group-text" id="formtabs-email2"
                                                  dir="ltr">@example.com</span>
                                        <input type="text" id="formtabs-email" class="form-control text-start"
                                               placeholder="john.doe" aria-label="john.doe"
                                               aria-describedby="formtabs-email2" dir="ltr">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-password-toggle">
                                        <label class="form-label" for="formtabs-password">رمز عبور</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="formtabs-password"
                                                   class="form-control text-start" placeholder="············"
                                                   dir="ltr" aria-describedby="formtabs-password2">
                                            <span class="input-group-text cursor-pointer" id="formtabs-password2"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-password-toggle">
                                        <label class="form-label" for="formtabs-confirm-password">تایید رمز
                                            عبور</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="formtabs-confirm-password"
                                                   class="form-control text-start" placeholder="············"
                                                   dir="ltr" aria-describedby="formtabs-confirm-password2">
                                            <span class="input-group-text cursor-pointer"
                                                  id="formtabs-confirm-password2"><i class="bx bx-hide"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">ثبت</button>
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
