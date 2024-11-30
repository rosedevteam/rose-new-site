<!DOCTYPE html>
<html lang="fa" class="light-style customizer-hide" dir="rtl" data-theme="theme-default" data-assets-path="/assets/admin/" data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

      <title>ورود</title>

    <meta name="description" content="">

    <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="/assets/admin/img/favicon/favicon.svg">

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/admin/vendor/fonts/boxicons.css">
    <link rel="stylesheet" href="/assets/admin/vendor/fonts/fontawesome.css">
    <link rel="stylesheet" href="/assets/admin/vendor/fonts/flag-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/admin/vendor/css/rtl/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="/assets/admin/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css">
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
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
                <div class="d-flex flex-column justify-content-center">
                    <div class="app-brand justify-content-center flex-column">
                        <img src="/assets/admin/img/branding/logo.svg" alt="logo">
                    </div>
                </div>
              <!-- /Logo -->
                <p class="mb-4">لطفا وارد حساب خود شوید.</p>
                <form id="formAuthentication" class="mb-3" action="{{ route("admin.login") }}" method="POST">
                    @csrf
                <div class="mb-3">
                    <label for="phone" class="form-label">شماره موبایل</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror text-start" id="phone"
                           name="phone"
                           placeholder="شماره موبایل خود را وارد کنید" autofocus dir="ltr">
                    @error('phone')
                    <div class="error" data-field="phone" data-validator="notEmpty">شماره وارد شده نامعتبر است.</div>
                    @enderror
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">ورود</button>
                </div>
              </form>
            </div>
          </div>
        </div>
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
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="/assets/admin/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/admin/js/pages-auth.js"></script>
  </body>
</html>
