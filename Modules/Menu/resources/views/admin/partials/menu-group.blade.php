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
            @can('delete-posts')
                <x-admin::deletebutton/>
            @endcan
        </td>

        @if($menu->children->count())
            @include('menu::admin.partials.menu-group' ,
            ['menus' => $menu->children , 'child' => true , 'level' => $level+1])
        @endif
    </tr>
    <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mb-4 mt-0 mt-md-n2">
                        <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                    </div>
                    <form id="deleteForm" action="{{ route("admin.menus.destroy", $menu) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-danger me-sm-3 me-1">حذف</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                انصراف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endforeach


