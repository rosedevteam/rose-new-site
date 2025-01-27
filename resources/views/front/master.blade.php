<!doctype html>
<html dir="rtl" lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/admin/img/favicon/favicon.svg">
    <link rel="alternate" hreflang="fa-IR" href="https://roseoj.com/"/>

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('assets/front/css/icons/bootstrap-icons/font/bootstrap-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/vendor/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/vendor/formvalidation/dist/css/formValidation.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/app.css')}}">

    @yield('head')

    {!! SEO::generate(true) !!}
</head>
<body class="body-bg-default @yield('body_class')">

{{--Nav Menu--}}
@include('front.partials.nav')
{{--Nav Menu End--}}

{{--Main Content--}}
@yield('content')
{{--Main Content End--}}


{{--Footer--}}
@include('front.partials.footer')
{{--Footer End--}}

<!--script-->

<script src="{{asset('assets/front/js/jquery.js')}}"></script>

<script src="{{asset('assets/front/js/jquery-ui.min.js')}}"></script>

<script src="{{asset('assets/front/js/bootstrap/popper.min.js')}}"></script>

<script src="{{asset('assets/front/js/bootstrap/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/front/vendor/owl-carousel/owl.carousel.js')}}"></script>

<script src="{{asset('assets/vendor/sweetalert/sweetalert2.js')}}"></script>

<script src="{{asset('assets/front/vendor/formvalidation/dist/js/formValidation.js')}}"></script>

<script src="{{asset('assets/front/vendor/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>

<script src="{{asset('assets/front/vendor/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

<script src="{{asset('assets/front/vendor/block-ui/block-ui.js')}}"></script>

<script src="{{asset('assets/vendor/axios/axios.min.js')}}"></script>

<script src="{{asset('assets/front/vendor/cleavejs/cleave.js')}}"></script>

<script src="{{asset('assets/front/js/axios-loader.js')}}"></script>

<script src="{{asset('assets/front/js/cart.js')}}"></script>

<script src="{{asset('assets/front/js/login.js')}}"></script>

<script src="{{asset('assets/front/js/app.js')}}"></script>

@yield('footer')
@include('sweetalert::alert')
</body>
</html>
