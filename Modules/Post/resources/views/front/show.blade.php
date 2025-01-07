@component('front.master')
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col d-flex align-items-start">
                    <ul class="tm-breadcrumb-1 p-0">
                        <li class="tm-breadcrumb-item"><a href="/"><i class="bi bi-house-door"></i></a></li>
                        <li class="tm-breadcrumb-item"><a href="/blog">وبلاگ</a></li>
                        <li class="tm-breadcrumb-item"><a href="#">{{ $post->title }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <div class="row gx-5">
                    <div class="col-xl-8 col-lg-8">
                        <div class="card border-0">
                            <div class="px-lg-5 py-xl-5">
                                <div class="row pb-4">
                                        <span>
                                    @php
                                        $len = count($post->categories()->get())-1;
                                        $i = 0
                                    @endphp
                                            @foreach($post->categories as $category)
                                                <a href="/blog?category={{ $category->archive_slug }}">
                                            {{ $category->name }}
                                        </a>{{ $i != $len ? "," : "" }}
                                                @php $i++ @endphp
                                            @endforeach</span>
                                </div>
                                <div class="pb-4 fs-4">
                                    {{ $post->title }}
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" class="ms-2"
                                         fill="none">
                                        <path
                                            d="M18.383 8H19.444C20.304 8 21 8.696 21 9.556V19.445C21 20.304 20.304 21 19.444 21H8.556C7.696 21 7 20.304 7 19.444V18"
                                            stroke="#0FABB5" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M4.00109 18H15.3131C15.9821 18 16.6061 17.666 16.9771 17.109L17.7111 16.007C18.1491 15.35 18.3831 14.578 18.3831 13.788V6C18.3831 4.895 17.4881 4 16.3831 4H6.38309C5.27809 4 4.38309 4.895 4.38309 6V13.056C4.38309 13.677 4.23809 14.289 3.96109 14.845L3.10709 16.553C2.77409 17.218 3.25809 18 4.00109 18Z"
                                              stroke="#0FABB5" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                        <path d="M8.38086 3V5" stroke="#0FABB5" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M14.3809 3V5" stroke="#0FABB5" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M8.18945 9H14.1895" stroke="#0FABB5" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M8.18945 13H14.1895" stroke="#0FABB5" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>{{ verta($post->created_at)->formatJalaliDate() }}</div>
                                <div class="pt-4">
                                    {!! $post->content !!}
                                </div>
                            </div>
                        </div>
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
