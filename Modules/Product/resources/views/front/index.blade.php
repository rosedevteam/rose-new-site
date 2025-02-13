@component('front.master')
    @section('content')
        <div class="container">
            <section class="mt-4">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="rose-product-card position-relative">
                                <div class="thumbnail">
                                    <img src="{{$product->image}}" alt="">
                                </div>
                                <div class="desc-wrapper">
                                    <h3 class="title">
                                        <a href="{{route('products.show' , $product)}}">
                                            {{$product->title}}
                                        </a>
                                    </h3>
                                    <p class="desc">
                                        {{$product->short_description}}
                                    </p>
                                </div>
                                <div class="badge-box">
                                    <div class="rose-badge">
                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.76958 2.28894C11.2517 2.70602 13.1446 4.85969 13.1446 7.46019C13.1446 10.3599 10.7943 12.7102 7.89458 12.7102C5.29408 12.7102 3.14041 10.8173 2.72333 8.33519"
                                                  stroke="#737887" stroke-width="0.875" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M2.72262 6.58601C2.77804 6.25643 2.86379 5.93851 2.97754 5.63284"
                                                  stroke="#737887"
                                                  stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M4.54839 3.41544C4.29347 3.62602 4.05955 3.85994 3.84897 4.11485"
                                                  stroke="#737887"
                                                  stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.01954 2.28907C6.68996 2.34449 6.37146 2.43082 6.06638 2.54457"
                                                  stroke="#737887"
                                                  stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.16154 4.58325V7.728H5.60013" stroke="#737887" stroke-width="0.875"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p>{{$product->duration}}</p>
                                    </div>
                                </div>
                               @if($product->is_free)
                                   <p class="text-decoration-none fw-bold text-black">رایگان</p>
                                @else
                                   @if($product->isOnSale())
                                       @php
                                       $discount_percent = (($product->price - $product->sale_price) / $product->price) * 100
                                       @endphp
                                        <div class="price-wrapper">
                                            <p class="price">
                                                {{number_format($product->price)}}
                                                تومان
                                            </p>
                                            <p class="sale-price">
                                                {{number_format($product->sale_price)}}
                                                تومان
                                            </p>

                                            <span class="discount-label">
                                                {{round($discount_percent )}} %
                                                تخفیف
                                            </span>
                                        </div>
                                    @else
                                        <div class="price-wrapper">
                                            <p class="price text-decoration-none fw-bold text-black">
                                                {{number_format($product->price)}}
                                                تومان
                                            </p>
                                        </div>
                                   @endif
                               @endif
                                @php
                                    $isOutOfStock = $product->status == "outofstock"
                                @endphp
                                @if($product->status == 'public')
                                    <a href="{{route('products.show' , $product)}}" class="btn btn-default"> جزئیات و ثبت نام</a>
                                @else
                                    <a role="button" class="btn btn-default" id="reserve"
                                       data-product="{{$product->id}}">رزرو</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                        {{ $products->links() }}
                </div>
            </section>
        </div>
    @endsection

    @section('footer')
            <script src="{{ asset('assets/front/js/products/reserve.js') }}"></script>
    @stop
@endcomponent
