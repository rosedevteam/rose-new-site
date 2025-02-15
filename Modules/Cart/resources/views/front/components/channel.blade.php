@foreach(auth()->user()?->cart?->products ?? [] as $product)

    @php
    //hard code
    @endphp

    @if($product->telegramSubscriptions->count())
        <hr>
        <h4 class="color-default mb-3 ">اشتراک کانال تلگرام دوره{{$product->title}}</h4>

        @if($product->id == 23423)
            @if(userHasCourse(2580) || userHasCourse(2013) ||userHasCourse(14216))
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading " style="font-size: 1rem;">توجه</h4>
                    <p style="font-size: .8rem;">این دوره شامل اشتراک رایگان کانال جامع تحلیل و بررسی سهام نمیباشد، در
                        صورتی
                        که تمایل دارید داخل کانال عضو شوید گزینه مورد نظر را از قسمت "اشتراک کانال جامع تحلیل و بررسی
                        سهام"
                        انتخاب نمایید</p>
                </div>

                <select name="telegram" id="telegram" class="form-select">
                    <option value="null,{{$product->id}}" selected>احتیاجی ندارم</option>
                    @foreach($product->telegramSubscriptions as $sub)
                        <option value="{{$sub->id}},{{$product->id}}" @if(auth()->user()?->cart?->getTelegramSubscription()?->id == $sub->id) selected @endif>{{$sub->name}} - {{number_format($sub->price)}} تومان</option>
                    @endforeach

                </select>
            @else
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading" style="font-size: 1rem;">توجه</h4>
                    <p style="font-size: .8rem;">با ثبت نام در این دوره شما 6 ماه به صورت رایگان عضو کانال جامع تحلیل و
                        بررسی سهام خواهید شد. در صورتی که علاقه به حضور یکساله در کانال هستید میتوانید گزینه "6 ماهه"
                        اشتراک
                        کانال جامع تحلیل و بررسی سهام را انتخاب کنید</p>
                </div>
                <select name="telegram" id="telegram" class="form-select">
                    <option value="null,{{$product->id}}" selected>احتیاجی ندارم</option>
                    @foreach($product->telegramSubscriptions->where('duration' , 6) as $sub)
                        <option value="{{$sub->id}},{{$product->id}}" @if(auth()->user()?->cart?->getTelegramSubscription()?->id == $sub->id) selected @endif>{{$sub->name}} - {{number_format($sub->price)}} تومان</option>
                    @endforeach

                </select>

            @endif
        @else
            <select name="telegram" id="telegram" class="form-select">
                <option value="null,{{$product->id}}" selected>احتیاجی ندارم</option>
                @foreach($product->telegramSubscriptions as $sub)
                    <option value="{{$sub->id}},{{$product->id}}" @if(auth()->user()?->cart?->getTelegramSubscription()?->id == $sub->id) selected @endif>{{$sub->name}} - {{number_format($sub->price)}} تومان</option>
                @endforeach

            </select>
        @endif

    @endif
@endforeach
