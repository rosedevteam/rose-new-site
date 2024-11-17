@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
    $configData = \Illuminate\Support\Facades\Config::get('custom.custom');

    /* Display elements */
    $customizerHidden = ($customizerHidden ?? '');

@endphp

@extends('adminfront::layouts/commonMaster' )

@section('layoutContent')

<!-- Content -->
@yield('content')
<!--/ Content -->

@endsection
