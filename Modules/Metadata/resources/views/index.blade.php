@extends('metadata::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('metadata.name') !!}</p>
@endsection
