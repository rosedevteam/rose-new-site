<!DOCTYPE html>
<html lang="fa" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-bordered"
      data-assets-path="/assets/front/" data-template="vertical-menu-template" xmlns="http://www.w3.org/1999/html">
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
    <link rel="stylesheet" href="/assets/front/vendor/fonts/boxicons.css">
    <link rel="stylesheet" href="/assets/front/vendor/fonts/fontawesome.css">
    <link rel="stylesheet" href="/assets/front/vendor/fonts/flag-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/front/vendor/css/rtl/core-dark.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="/assets/front/vendor/css/rtl/theme-bordered-dark.css"
          class="template-customizer-theme-css">
    <link rel="stylesheet" href="/assets/front/css/demo.css">
    <link rel="stylesheet" href="/assets/front/vendor/css/rtl/rtl.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/front/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/front/vendor/libs/typeahead-js/typeahead.css">
    <link rel="stylesheet" href="/assets/front/vendor/libs/apex-charts/apex-charts.css">
    <link rel="stylesheet" href='/assets/vendor/sweetalert/sweetalert2.css'>
    <link rel="stylesheet" href="/assets/front/vendor/libs/swiper/swiper.css">

    @stack('css')

    @if(!auth()->user()->birthday)
        <link rel="stylesheet" href="{{asset('/assets/front/vendor/formvalidation/dist/css/formValidation.css')}}">
        <link rel="stylesheet" href="/assets/front/js/datepicker/persian-datepicker.min.css">
    @endif

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/front/vendor/js/helpers.js"></script>
    <link rel="stylesheet" href="/assets/front/css/profile/custom.css">

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/front/js/profile/config.js"></script>
</head>
<body>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <x-profile::sidebar/>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <x-profile::navbar/>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">

                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y mt-5">
                    <div class="my-4 d-lg-none">
                        <a href="https://roseoj.com" class="mb-4 back-to-core-website ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.47998 11.9805H19.47" stroke="#737887" stroke-width="1.5"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.4829 5.98828L19.5199 12.0003L13.4829 18.0123" stroke="#737887"
                                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            بازگشت به سایت
                        </a>
                    </div>
                    <!-- Content wrapper -->
                    @yield('content')
                    <!-- Content wrapper -->
                </div>
                <!-- / Content -->


                @if(!auth()->user()->birthday)
                    <div class="modal fade" id="set-birthday-modal" tabindex="-1" aria-hidden="true"
                         data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form id="birthday-form">
                                        <div class="text-center mb-4 mt-0 mt-md-n2">
                                            <h5 class="modal-title secondary-font" id="modalCenterTitle">لطفا تاریخ تولد
                                                خود را وارد کنید</h5>
                                        </div>
                                        <div class="col mx-3 mb-3">
                                            <div class="row mb-3">
                                                <input id="birthday" name="birthday" class="date-picker form-control"
                                                       autocomplete="off">
                                            </div>
                                            <div class="row row-cols-4 justify-content-center">
                                                <button class="btn btn-primary">ثبت</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="content-backdrop fade"></div>
            </div>

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
<script src="/assets/front/vendor/libs/jquery/jquery.js"></script>
<script src="/assets/front/vendor/libs/popper/popper.js"></script>
<script src="/assets/front/vendor/js/bootstrap.js"></script>
<script src="/assets/front/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="/assets/vendor/sweetalert/sweetalert2.js"></script>

<script src="/assets/front/vendor/libs/hammer/hammer.js"></script>

<script src="/assets/front/vendor/libs/i18n/i18n.js"></script>
<script src="/assets/front/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="/assets/front/vendor/block-ui/block-ui.js"></script>
<script src="/assets/vendor/axios/axios.min.js"></script>
<script src="/assets/front/js/axios-loader.js"></script>
<script src="/assets/front/vendor/libs/swiper/swiper.js"></script>
<script src="/assets/front/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
@stack('vendor')

<!-- Main JS -->
<script src="/assets/front/js/profile/custom.js"></script>
<script src="/assets/front/js/profile/main.js"></script>

@if(!auth()->user()->birthday)
    <script src="{{asset('/assets/front/vendor/formvalidation/dist/js/formValidation.js')}}"></script>
    <script src="{{asset('/assets/front/vendor/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('/assets/front/vendor/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="/assets/front/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/front/js/datepicker/persian-datepicker.min.js"></script>
    <script src="/assets/front/js/profile/force-birthday.js"></script>
@endif

<!-- Page JS -->
@stack('script')
@include('sweetalert::alert')
</body>
</html>
