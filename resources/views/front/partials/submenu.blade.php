@foreach($menus as $menu)
    <li>
        <a class="sub-menu-item" href="#">
            <div class="sub-menu-icon">
                <img src="{{$menu->icon}}" alt="">
            </div>
            <div class="sub-menu-title">
                <h3>{{$menu->title}}</h3>
                <p class="subtitle">
                    {{$menu->subtitle}}
                </p>
            </div>
        </a>
    </li>
@endforeach
