@extends('adminfront::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('adminfront::name') !!}</p>
@endsection
