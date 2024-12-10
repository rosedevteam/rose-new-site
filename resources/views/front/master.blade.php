<!doctype html>
<html dir="rtl" lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="">
    <link rel="alternate" hreflang="fa-IR" href="https://roseoj.com/"/>

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('assets/front/css/icons/bootstrap-icons/font/bootstrap-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/vendor/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/app.css')}}">

    @yield('head')

    <title>مجموعه آموزشی رز</title>
</head>
<body class="body-bg-default">

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

<script src="{{asset('assets/front/js/app.js')}}"></script>

@yield('footer')

</body>
</html>
