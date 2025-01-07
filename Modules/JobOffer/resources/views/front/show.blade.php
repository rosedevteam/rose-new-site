@component('front.master')
    @section('content')
        <div class="main-sec top-bg second-bg ">
            <div class="container ">
                <h2 class="rose-sec-title text-center mt-5 rose-py-7 pt-4">{{ $jobOffer->title }}</h2>
                <div class="row my-3 justify-content-between">
                    <div class="col">
                        <div class="fs-4 mb-3 description"><p>{{ $jobOffer->title }}</p></div>
                        <div>
                            @foreach($jobOffer->categories as $category)
                                <p class="badge">{{ $category->name }}</p>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" data-bs-target="#post-modal" class="btn btn-default btn-hero"
                            data-bs-toggle="modal">ارسال رزومه
                    </button>
                </div>
                <div class="card border-0">
                    <div class="m-lg-5">
                        <div class="row fs-4 mb-5 description"><p>شرح موقعیت شغلی</p></div>
                        <div class="description"><p>{!! $jobOffer->content !!}</p></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endcomponent
