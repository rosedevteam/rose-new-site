@extends('auth::layouts.master')

@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <!--  Two Steps Verification -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="#" class="app-brand-link">
                            <div class="app-brand justify-content-center">
                                <img src="/assets/admin/img/branding/logo.svg" width="100%">
                            </div>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <h4 class="mb-3 secondary-font">تایید دو مرحله‌ای</h4>
                    <p class="mb-0 fw-semibold">کد 6 رقمی امنیتی را وارد کنید</p>
                    <form id="twoStepsForm" action="{{route('admin.login.token.send')}}" method="POST">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <div
                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1" autofocus>
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                       maxlength="1">
                            </div>
                            <!-- Create a hidden field which is combined by 3 fields above -->
                            <input type="hidden" name="otp">
                        </div>
                        <button class="btn btn-primary d-grid w-100 mb-3">تایید</button>

                        <div class="text-center" id="timer">
                            ارسال دوباره کد تا:
                            <div class="countdown ms-2">2:00</div>
                        </div>

                        <div class="text-center" id="send-again" style="display: none">
                            کد را دریافت نکردید؟
                            <a href="{{route('admin.login')}}"> ارسال دوباره </a>
                        </div>

                        <div class="text-center">
                            <a href="{{route('admin.login')}}">
                                <i class="bx bx-chevron-left scaleX-n1-rtl"></i>
                                بازگشت به ورود
                            </a>
                        </div>

                    </form>
                </div>
            </div>
            <!-- / Two Steps Verification -->

        </div>
    </div>
@stop
