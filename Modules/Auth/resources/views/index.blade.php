@extends('front::layouts.master')

@section('title')
    {{ "پنل مدیریت" }}
@endsection

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('auth.name') !!}</p>
    {{ "dashboard" }}
@endsection
