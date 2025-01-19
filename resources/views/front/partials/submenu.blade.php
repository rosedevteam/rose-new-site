@foreach($menus as $menu)
    <li>
        <a class="sub-menu-item" href="{{ $menu->slug }}">
            @if($icon)
            <div class="sub-menu-icon">
                <img src="/assets/front/menu-icons/{{$menu->icon}}" alt="">
            </div>
            @endif
            <div class="sub-menu-title">
                <h3>{{$menu->title}}</h3>
                <p class="subtitle">
                    {{$menu->subtitle}}
                </p>
            </div>
        </a>
    </li>
@endforeach
