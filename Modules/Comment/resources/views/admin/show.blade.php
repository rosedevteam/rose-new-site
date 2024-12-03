@extends("admin::layouts.main")

@section('title')
    نظر
@endsection

@section("content")
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom mx-3">
                    <a href="{{
                    route("admin." . strtolower(substr(strrchr($comment->commentable_type, '\\'), 1)) . ".show", $comment->commentable)
                    }}" class="text-body text-truncate">
                        <span class="fw-semibold">{{ $comment->commentable->title }}</span></a>
                </div>
                <div class="card-content mx-5 my-5">
                    <div class="row justify-content-start">
                        <div class="row mx-2 my-2">
                            <div class="col">
                                <form action="{{ route("admin.comment.update", $comment) }}" method="POST">
                                    <button type="submit" class="btn btn-sm btn-icon">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                </form>
                                {{ "- " . $comment->author()->name() . " :" }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="row mx-4">
                                {{ $comment->content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
