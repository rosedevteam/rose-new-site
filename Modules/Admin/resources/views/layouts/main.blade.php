<!DOCTYPE html>
<html lang="fa" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default"
      data-assets-path="/assets/admin/" data-template="vertical-menu-template" xmlns="http://www.w3.org/1999/html">
<head>

    {!! SEO::generate() !!}

    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}" id="csrf">
    <meta charset="utf-8" name="description" content="">

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
    <link rel="stylesheet" href="/assets/admin/vendor/libs/apex-charts/apex-charts.css">

    @stack('css')

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/admin/vendor/js/helpers.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/admin/js/config.js"></script>
</head>
<body>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <x-admin::sidebar/>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <x-admin::navbar/>
            <!-- / Navbar -->

            <!-- Content wrapper -->
                @yield('content')
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="/assets/admin/vendor/libs/jquery/jquery.js"></script>
<script src="/assets/admin/vendor/libs/popper/popper.js"></script>
<script src="/assets/admin/vendor/js/bootstrap.js"></script>
<script src="/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/assets/admin/vendor/libs/hammer/hammer.js"></script>

<script src="/assets/admin/vendor/libs/i18n/i18n.js"></script>
<script src="/assets/admin/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="/assets/vendor/axios/axios.min.js"></script>

<script src="/assets/admin/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
@stack('vendor')

<!-- Main JS -->
<script src="/assets/admin/js/main.js"></script>

<!-- Page JS -->
@stack('script')
@include('sweetalert::alert')
</body>
</html>
