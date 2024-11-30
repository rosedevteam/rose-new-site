<!DOCTYPE html>
<html lang="fa" class="light-style customizer-hide" dir="rtl" data-theme="theme-default"
      data-assets-path="/assets/admin/" data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

      <title>تایید دو مرحله‌ای</title>

    <meta name="description" content="">

    <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="/assets/admin/img/favicon/favicon.svg">

    <!-- Icons -->
      <link rel="stylesheet" href="/assets/admin/vendor/fonts/boxicons.css">
      <link rel="stylesheet" href="/assets/admin/vendor/fonts/fontawesome.css">
      <link rel="stylesheet" href="/assets/admin/vendor/fonts/flag-icons.css">

    <!-- Core CSS -->
      <link rel="stylesheet" href="/assets/admin/vendor/css/rtl/core.css" class="template-customizer-core-css">
      <link rel="stylesheet" href="/assets/admin/vendor/css/rtl/theme-default.css"
            class="template-customizer-theme-css">
      <link rel="stylesheet" href="/assets/admin/css/demo.css">
      <link rel="stylesheet" href="/assets/admin/vendor/css/rtl/rtl.css">

    <!-- Vendors CSS -->
      <link rel="stylesheet" href="/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
      <link rel="stylesheet" href="/assets/admin/vendor/libs/typeahead-js/typeahead.css">
    <!-- Vendor -->
      <link rel="stylesheet" href="/assets/admin/vendor/libs/formvalidation/dist/css/formValidation.min.css">

    <!-- Page CSS -->
    <!-- Page -->
      <link rel="stylesheet" href="/assets/admin/vendor/css/pages/page-auth.css">
    <!-- Helpers -->
      <script src="/assets/admin/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
      <script src="/assets/admin/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="/assets/admin/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-basic px-4">
      <div class="authentication-inner py-4">
        <!--  Two Steps Verification -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
              <div class="d-flex flex-column justify-content-center">
                  <div class="app-brand justify-content-center flex-column">
                      <img src="/assets/admin/img/branding/logo.svg" alt="logo">
            </div>
            <!-- /Logo -->
            <h4 class="mb-3 secondary-font">تایید دو مرحله‌ای</h4>
            <p class="text-start mb-4">
              ما یک کد تایید به موبایل شما ارسال کردیم. کد ارسال شده را در فیلد زیر وارد کنید.
                @session('phone')<span class="fw-bold d-block mt-2">{{ $value['phone'] }}</span>@endSession
            </p>
            <p class="mb-0 fw-semibold">کد 6 رقمی امنیتی را وارد کنید</p>
              <form id="twoStepsForm" action="{{ route("admin.otp") }}" method="POST">
                  @csrf
              <div class="mb-3">
                <div class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                    <input type="text"
                           class="form-control @if($error) is-invalid @endif auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                           maxlength="1" autofocus>
                    <input type="text"
                           class="form-control @if($error) is-invalid @endif auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                           maxlength="1">
                    <input type="text"
                           class="form-control @if($error) is-invalid @endif auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                           maxlength="1">
                    <input type="text"
                           class="form-control @if($error) is-invalid @endif auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                           maxlength="1">
                    <input type="text"
                           class="form-control @if($error) is-invalid @endif auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                           maxlength="1">
                    <input type="text"
                           class="form-control @if($error) is-invalid @endif auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                           maxlength="1">
                </div>
                <!-- Create a hidden field which is combined by 3 fields above -->
                <input type="hidden" name="otp">
                  @if($error)
                      <div class="error" data-validator="notEmpty">رمز وارد شده اشتباه است.</div>
                  @endif
              </div>
              <button class="btn btn-primary d-grid w-100 mb-3">تایید حساب</button>
              <div class="text-center">
                کد را دریافت نکردید؟
                <a href="javascript:void(0);"> ارسال دوباره </a>
              </div>
            </form>
          </div>
        <!-- / Two Steps Verification -->
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/admin/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/admin/vendor/libs/popper/popper.js"></script>
    <script src="/assets/admin/vendor/js/bootstrap.js"></script>
    <script src="/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/admin/vendor/libs/hammer/hammer.js"></script>

    <script src="/assets/admin/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/admin/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="/assets/admin/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/admin/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="/assets/admin/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/admin/js/pages-auth.js"></script>
    <script src="/assets/admin/js/pages-auth-two-steps.js"></script>
  </body>
</html>
