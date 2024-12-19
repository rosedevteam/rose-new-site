@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom mx-3">
                    <div class="row justify-content-start">
                        <div class="col">
                            <h1>{{ $post->title }}</h1>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-sm btn-icon mt-3">
                                <a href="{{ route('admin.posts.edit', $post) }}">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="card-content mx-5 my-5">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
        </div>
@endsection
