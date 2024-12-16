@extends('auth::layouts.master')

@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <!-- Register -->
            <div class="card" id="login">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="d-flex flex-column justify-content-center">
                        <div class="app-brand justify-content-center flex-column">
                            <a href="#" class="app-brand-link gap-2">
                                <img src="/assets/admin/img/branding/Logo.svg" width="100%">
                            </a>
                        </div>

                    </div>

                    <!-- /Logo -->


                    <div class="logo-box">
                        <form id="formAuthentication" action="{{route('admin.login')}}" class="mb-3" method="POST">
                            @csrf
                            @method('post')
                            <div class="mb-3">
                                <label for="phone" class="form-label">لطفا موبایل را وارد کنید</label>
                                <div class="input-group">
                                    <input type="text"
                                           id="phone"
                                           class="form-control @error('phone') is-invalid @enderror phone-number-mask text-start"
                                           name="phone"
                                           placeholder="0912 123 4567"
                                           autocomplete="off"
                                           dir="ltr"
                                           required>
                                    <span class="input-group-text">IR (+98)</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100 edit-this btn-page-block-spinner" type="submit" id="submit-form">ورود</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Register -->

        </div>
    </div>
@stop
