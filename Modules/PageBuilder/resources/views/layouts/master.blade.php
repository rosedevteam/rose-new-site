<!doctype html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="">
    <link rel="alternate" hreflang="fa-IR" href="https://roseoj.com/"/>

    <!-- Style -->

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script  src="https://unpkg.com/grapesjs"></script>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">

    <script src="https://unpkg.com/grapesjs-typed"></script>
    <script src="https://unpkg.com/grapesjs-parser-postcss"></script>
    <script src="https://unpkg.com/grapesjs-custom-code"></script>

    <script src="https://cdn.ckeditor.com/4.14.1/standard-all/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/grapesjs-plugin-ckeditor@0.0.9/dist/grapesjs-plugin-ckeditor.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @yield('head')

    <title>مجموعه آموزشی رز</title>
</head>
<body class="body-bg-default">

{{--Nav Menu--}}
{{--@include('front.partials.nav')--}}
{{--Nav Menu End--}}

    {{--Main Content--}}
    @yield('content')
    {{--Main Content End--}}



{{--Footer--}}
{{--@include('front.partials.footer')--}}
{{--Footer End--}}

<!--script-->

<script src="{{asset('assets/front/js/jquery.js')}}"></script>

{{--<script src="{{asset('assets/front/js/jquery-ui.min.js')}}"></script>--}}

{{--<script src="{{asset('assets/front/js/bootstrap/popper.min.js')}}"></script>--}}

{{--<script src="{{asset('assets/front/js/bootstrap/bootstrap.min.js')}}"></script>--}}

{{--<script src="{{asset('assets/front/vendor/owl-carousel/owl.carousel.js')}}"></script>--}}




{{--<script src="{{asset('assets/front/js/app.js')}}"></script>--}}
<script type="module" src="{{asset('assets/admin/js/pagebuilder.js')}}"></script>

@yield('footer')

</body>
</html>
