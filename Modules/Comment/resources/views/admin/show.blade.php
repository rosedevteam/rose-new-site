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
                    کامنت برای:
                    <a href="{{
                    route("admin." . strtolower(substr(strrchr($comment->commentable_type, '\\'), 1)) . "s.show", $comment->commentable)
                    }}" class="text-body text-truncate">
                        <span class="fw-semibold">{{ $comment->commentable->title }}</span></a>
                </div>
                <div class="card-content mx-5 my-5">
                    <div class="row justify-content-start">
                        <div class="row mx-2 my-2">
                            <div class="col mb-2">
                                نویسنده:
                                <a href="{{ route("admin.users.show", $comment->author()->first()) }}">
                                    {{ $comment->author()->first()->name() }}
                                </a>
                            </div>
                        </div>
                        <div class="row mx-4 mb-4">
                            کامنت:
                            {{ $comment->content }}
                        </div>
                        @can('edit-comments')
                            <form action="{{ route("admin.comments.update", $comment) }}" method="POST">
                                <div class="row">
                                    @method("PATCH")
                                    @csrf
                                    <div class="col-md-2">
                                        <label for="status" class="form-label">وضعیت</label>
                                        <select class="form-select" id="status" name="status">
                                            <option
                                                value="approved" {{ $comment->status == "approved" ? "selected" : "" }}>
                                                تایید شده
                                            </option>
                                            <option
                                                value="pending" {{ $comment->status == "pending" ? "selected" : "" }}>در
                                                انتظار
                                            </option>
                                            <option
                                                value="rejected" {{ $comment->status == "rejected" ? "selected" : "" }}>
                                                رد شده
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="submit" class="btn btn-primary">تغییر</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route("admin.comments.reply", $comment) }}" method="POST">
                                @csrf
                                <div class="row mt-5">
                                    <label class="form-label" for="content">پاسخ</label>
                                    <textarea class="form-control" id="content" name="content"></textarea>
                                    <div class="col-md-2 mt-3">
                                        <button class="btn btn-primary" type="submit">ثبت</button>
                                    </div>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
@endsection
