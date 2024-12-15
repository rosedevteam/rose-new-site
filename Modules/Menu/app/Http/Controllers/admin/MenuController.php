<?php

namespace Modules\Menu\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Validation\Rules\File;
use Modules\Menu\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        Gate::authorize('view-menus');
        try {
            $menus = Menu::query()
                ->where('parent_id')
                ->orderBy('order');
            $active = $menus->get()->where('is_active', true);
            $inactive = $menus->get()->where('is_active', false);
            return view('menu::admin.index', compact('active', 'inactive'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function show(Menu $menu)
    {
        Gate::authorize('view-menus');
        try {
            if (!$menu->has_children) {
                return view('menu::admin.show', compact('menu'));
            }
            $children = $menu->children();
            $active = $children->get()->where('is_active', true);
            $inactive = $children->where('is_active', false);
            return view('menu::admin.show', compact('menu', 'active', 'inactive'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function update(Menu $menu)
    {
        Gate::authorize('edit-menus');
        $data = request()->validate([
            'name' => 'bail|nullable|string',
            'slug' => 'bail|nullable|string',
            'is_active' => 'bail|nullable|boolean',
            'has_children' => 'bail|nullable|boolean',
            'icon' => [
                'bail',
                'nullable',
                File::types(['svg'])
            ]
        ]);
        try {
            if (!is_null($data['icon'])) {
                $name = 'menu-icon-' . now()->timestamp . '.pdf';
                request()->file('icon')->storeAs('assests/admin/svg/icons', $name, 'public');
                $data['icon'] = null;
            }
            $data = array_filter($data, function ($value) {
                return !is_null($value);
            });
            $menu->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menu)
                ->withProperties($data)
                ->log('ویرایش آیتم منو');
            alert()->success('موفق', 'با موفقیت انجام شد');
            return redirect(route('admin.menus.show', $menu));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-menus');
        $data = request()->validate([
            'name' => 'bail|required|string',
            'slug' => 'bail|nullable|string',
        ]);
        try {
            $menu = Menu::create([
                'name' => $data['name'],
                'slug' => $data['slug'] ?: '#',
                'icon' => null,
                'author_id' => auth()->id(),
                'has_children' => false,
                'order' => null,
                'parent_id' => null,
                'is_active' => false,
            ]);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menu)
                ->withProperties($data)
                ->log('ساخت آیتم منو جدید');
            alert()->success('موفق', 'آیتم منو جدید ساخته شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function destroy(Menu $menu)
    {
        Gate::authorize('delete-menus');
        try {
            $menu->delete();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menu)
                ->log('حذف منو');
            alert()->success('موفق', 'با موفقیت انجام شد');
            return route('admin.menus.index');
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function sort()
    {
        Gate::authorize('edit-menus');
        try {
            $data = request()->validate([
                '*.id' => 'required|integer|exists:menus,id',
                '*.order' => 'required|integer|min:1',
                '*.status' => 'required|boolean',
            ]);
            foreach ($data as $item) {
                $menu = Menu::where('id', $item['id'])->first();
                $menu->update([
                    'order' => $item['order'],
                    'is_active' => $item['status'],
                ]);
            }
            activity()
                ->causedBy(auth()->user())
                ->withProperties($data)
                ->log('ویرایش منو با موفقیت انجام شد');
            alert()->success('موفق', 'ویرایش منو با موفقیت انجام شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

}
