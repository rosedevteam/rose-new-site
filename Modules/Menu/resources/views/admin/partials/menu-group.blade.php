@foreach($menus as $menu)
    <tr>
        <td class="fw-semibold">
            {{$menu->id}}
        </td>
        <td class="sorting_1">
            {{ str_repeat('--- ' , $level)  . $menu->title}}
        </td>
        <td>{{ $menu->link }}</td>
        <td>
            {{$menu->author->first_name . ' ' . $menu->author->last_name}}
        </td>
        <td>{{ verta($menu->created_at)->formatJalaliDateTime() }}</td>
        <td>
            <div class="d-inline-block text-nowrap">
                <a href="" class="btn btn-sm btn-danger">
                    حذف
                </a>
            </div>
        </td>

        @if($menu->children->count())
            @include('menu::admin.partials.menu-group' ,
            ['menus' => $menu->children , 'child' => true , 'level' => $level+1])
        @endif
    </tr>
@endforeach


