@extends("profile::layouts.main")

@section('content')

    <div class="panel-title-box d-flex justify-content-between flex-column flex-sm-row align-items-sm-center">
        <div class="mb-3 mb-sm-0">
            <h3>مجموعه آموزشی رز</h3>
            <h2>سفارش های من</h2>
        </div>
    </div>


    {{--  Courses  --}}
    <div id="courses" class="row g-3">
        @php
        $userProducts = auth()->user()->orders()->with('products')->get()->pluck('products.*.id')->flatten()->unique()->toArray()
        @endphp

        <div class=" col-md-6 col-12">
            <div class="course-holder flex-column flex-lg-row">
                <div class="course-thumb">
                    <img src="${item.image.src}" alt="">
                </div>
                <div class="details d-flex flex-grow-1 justify-content-around flex-column flex-lg-row">
                    <div class="d-flex flex-column w-100 flex-grow-1">
                        <h3 class="course-title-th">عنوان دوره</h3>
                        <p class="desc">${item.name}</p>
                    </div>
                    <div class="d-flex flex-column w-100 flex-grow-1">
                        <h3 class="course-title-th">مشاهده دوره</h3>
                        <div class="d-flex ps-3 pe-3 desc gap-3 justify-content-center">
                            <button onclick="getProductPermalink(${item.product_id} , ${userId})" class="btn btn-primary " target="_blank">
                                مشاهده دوره
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  Courses end  --}}




    <div class="panel-title-box my-5">
        <div class="title-wrapper mb-4">
            <h3>همیشه درحال یادگیری باش!</h3>
            <h2>دوره های مجموعه آموزشی رز</h2>
        </div>
        <div class="row rose-courses my-2">
            <div class="row">
                @php
                    $userProducts = auth()->user()->orders()->with('products')->get()->pluck('products.*.id')->flatten()->unique()->toArray();
                @endphp
                @foreach(\Modules\Product\Models\Product::where('status' , 'public')->get() as $product)
                    <div class="col-md-3 course-item @if(!in_array($product->id , $userProducts)) false @endif">
                        @if(!in_array($product->id , $userProducts))
                            <p class="label">دانشجوی دوره نیستید</p>
                        @endif
                        <a href="{{route('products.show' , $product)}}">
                            <img
                                src="{{$product->image}}"
                                width="100%" style="border-radius: 10px;">
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@stop
