<!DOCTYPE html>
<html lang="fa" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    {!! SEO::generate() !!}

    @include('front::layouts.partials.head')

    @yield('head')
</head>

<body>


<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Menu -->

        @include('front::layouts.partials.side')

        <!-- / Menu -->


        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('front::layouts.partials.nav')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">

                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y my-5">
                    <div class="my-4 d-lg-none">
                        <a href="https://roseoj.com" class="mb-4 back-to-core-website ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.47998 11.9805H19.47" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.4829 5.98828L19.5199 12.0003L13.4829 18.0123" stroke="#737887" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            بازگشت به سایت
                        </a>
                    </div>
                    @yield('content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('front::layouts.partials.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
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

@include('front::layouts.partials.scripts')

@yield('footer')
</body>
</html>
