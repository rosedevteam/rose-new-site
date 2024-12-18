@foreach($menus as $menu)
    <tr>
        <td class="fw-semibold">
            {{$menu->id}}
        </td>
        <td class="sorting_1">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="d-flex flex-column">
                    <span class="fw-semibold">{{ $menu->title }}</span>
                </div>
            </div>
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
            @include('menu::backend.partials.menu-group' ,
            ['menus' => $menu->children , 'child' => true , 'level' => $level+1])
        @endif
    </tr>
@endforeach


{{--@foreach($menus as $menu)--}}
{{--    <tr>--}}
{{--        <td>--}}
{{--            {{ str_repeat('---' , $level) . ' menu-group.blade.php' . $menu->title}}--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <form action="{{route('admin.menus.destroy', $menu->id)}}" method="post"--}}
{{--                  id="delete-{{$menu->id}}">--}}
{{--                @method('delete')--}}
{{--                @csrf--}}
{{--            </form>--}}
{{--            <a href="{{route('admin.menus.edit',$menu->id) }}" role="button"--}}
{{--               class="btn btn-success light sharp" title="ویرایش">--}}
{{--                <i class="fa fa-pencil"--}}
{{--                   onclick="document.getElementById('edit-{{$menu->id}}').submit()"></i>--}}
{{--            </a>--}}
{{--            <button onclick="document.getElementById('delete-{{$menu->id}}').submit()"--}}
{{--                    role="button" class="btn btn-danger light sharp" title="حذف">--}}
{{--                <i class="fa fa-trash"></i>--}}
{{--            </button>--}}
{{--            <a href="{{$menu->link}}" role="button"--}}
{{--               class="btn btn-primary light sharp" title="نمایش" target="_blank">--}}
{{--                <i class="fa fa-eye"></i>--}}
{{--            </a>--}}

{{--        </td>--}}
{{--        @if($menu->children->count())--}}
{{--            @include('menu::backend.partials.menu-group' ,--}}
{{--            ['menus' => $menu->children , 'child' => true , 'level' => $level+1])--}}
{{--        @endif--}}
{{--    </tr>--}}
{{--@endforeach--}}
