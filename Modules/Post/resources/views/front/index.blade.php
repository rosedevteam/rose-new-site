@component('front.master')
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col d-flex align-items-start">
                    <ul class="tm-breadcrumb-1 p-0">
                        <li class="tm-breadcrumb-item"><a href="/"><i class="bi bi-house-door"></i></a></li>
                        <li class="tm-breadcrumb-item">وبلاگ</li>
                    </ul>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <div class="row gx-5">
                    <div class="col-xl-8 col-lg-8">
                        <div class="row">
                            @foreach($posts as $post)
                                <div class="col-xl-4">
                                    <div class="post-card mb-3 bg-white br-default p-3">
                                        <figure class="post-image">
                                            <a href="{{ route('posts.show', $post) }}">
                                                <img src="{{ $post->image }}" alt="">
                                            </a>
                                        </figure>
                                        <div class="post-details">
                                            <div class="post-meta">
                                                <a href="#"
                                                   class="post-date">{{ verta($post->created_at)->formatJalaliDate() }}</a>
                                            </div>
                                            <h3 class="post-title">
                                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                            </h3>
                                            <div class="post-content">
                                                <p>{!! Str::limit(strip_tags($post->content)) !!}</p>
                                            </div>
                                            <div class="post-footer">
                                                <a href="{{ route('posts.show', $post) }}" class="btn btn-link">
                                                    مطالعه مقاله
                                                    <i class="bi bi-arrow-left"></i>
                                                </a>
                                                <div class="post-comments">
                                                    <a href="#">
                                                        {{ $post->comment_status ? $post->comments_count : 0 }}
                                                        <i class="bi bi-chat-left"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $posts->links() }}
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="blog-categories-widget mt-4 br-default bg-white b-none">
                            <div class="title-box no-line">
                                <div class="title-wrapper gap-2">
                                    <i class="bi bi-chevron-left color-default"></i>
                                    <h3 class="title title-line">
                                        دسته بندی ها
                                    </h3>
                                </div>
                            </div>
                            <ul class="blog-categories p-0">
                                @foreach($categories as $category)
                                    <li class="category-item ">
                                        <a href="?category={{ $category->archive_slug }}">
                                            <div class="d-flex justify-content-between br-default">
                                                {{ $category->name }}
                                                <span>{{ $category->posts_count }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endcomponent
