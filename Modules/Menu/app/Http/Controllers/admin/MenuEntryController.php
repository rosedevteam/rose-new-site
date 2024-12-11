<?php

namespace Modules\Menu\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Validation\Rules\File;
use Modules\Menu\Models\MenuEntry;

class MenuEntryController extends Controller
{
    public function index()
    {
        Gate::authorize('view-menu-entries');
        try {
            $sort_direction = request('sort_direction', 'desc');
            $menuEntries = MenuEntry::query()
                ->orderBy('created_at', $sort_direction)
                ->paginate(50);
            return view('menu::admin.index', compact('menuEntries', 'sort_direction'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function show(MenuEntry $menuEntry)
    {
        Gate::authorize('view-menu-entries');
        try {
            $children = $menuEntry->children()->get();
            return view('menu::admin.show', compact('menuEntry', 'children'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function update(MenuEntry $menuEntry)
    {
        Gate::authorize('edit-menu-entries');
        $data = request()->validate([
            'name' => 'bail|nullable|string',
            'slug' => 'bail|nullable|string',
            'is_parent' => 'bail|nullable|boolean',
            'is_active' => 'bail|nullable|boolean',
            'parent_id' => 'bail|nullable|integer',
            'icon' => [
                'bail',
                'nullable',
                File::types(['svg'])
            ]
        ]);
        try {
            $data = array_filter($data, function ($value) {
                return !is_null($value);
            });
            $data -= $data['icon'];
            $name = 'menu-icon-' . now()->timestamp . '.pdf';
            request()->file('icon')->storeAs('assests/admin/svg/icons', $name, 'public');
            $menuEntry->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menuEntry)
                ->withProperties($data)
                ->log('ویرایش آیتم منو');
            alert()->success('موفق', 'با موفقیت انجام شد');
            return redirect(route('admin.menu.show', $menuEntry));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function create()
    {
       Gate::authorize('create-menu-entries');
       try {
           $parents = MenuEntry::where('is_parent', true)->get();
           return view('menu::admin.create', compact('parents'));
       } catch (\Throwable $th) {
           alert()->error('خطا', $th->getMessage());
           return back();
       }
    }

    public function store()
    {
        Gate::authorize('create-menu-entries');
        $data = request()->validate([
            'name' => 'bail|required|string',
            'slug' => 'bail|required|string',
            'is_parent' => 'bail|required|boolean',
            'order' => 'bail|required|int',
            'parent_id' => 'bail|required|integer',
            'icon' => [
                'bail',
                'required',
                File::types(['svg'])
            ]
        ]);
        try {
            $name = 'menu-icon-' . now()->timestamp . '.pdf';
            request()->file('icon')->storeAs('assests/admin/svg/icons', $name, 'public');
            $menuEntry = MenuEntry::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'is_parent' => $data['is_parent'],
                'icon' => $name,
                'author_id' => auth()->id
            ]);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menuEntry)
                ->withProperties($data)
                ->log('ساخت آیتم منو جدید');
            alert()->success('موفق', 'آیتم منو جدید ساخته شد');
            return redirect(route('admin.menu.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }
}
