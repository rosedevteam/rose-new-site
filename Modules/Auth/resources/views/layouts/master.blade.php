<!DOCTYPE html>
<html lang="fa" class="light-style customizer-hide" dir="rtl" data-theme="theme-default"
      data-assets-path="/admin/assets/" data-template="vertical-menu-template">

@include('auth::admin.partials.header')

<body>
<!-- Content -->

<div class="container-xxl">
    @yield('content')
</div>

<!-- / Content -->

@include('auth::admin.partials.footer')

</body>
</html>
