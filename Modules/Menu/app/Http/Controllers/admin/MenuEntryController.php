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
            $menuEntries = MenuEntry::query()
                ->where('is_parent', true)
                ->orderBy('order');
            $active = $menuEntries->get()->where('is_active', true);
            $inactive = $menuEntries->get()->where('is_active', false);
            return view('menu::admin.index', compact('active', 'inactive'));
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
            'is_active' => 'bail|nullable|boolean',
            'icon' => [
                'bail',
                'nullable',
                File::types(['svg'])
            ]
        ]);
        try {
            if(!is_null($data['icon'])) {
                $name = 'menu-icon-' . now()->timestamp . '.pdf';
                request()->file('icon')->storeAs('assests/admin/svg/icons', $name, 'public');
                $data['icon'] = null;
            }
            $data = array_filter($data, function ($value) {
                return !is_null($value);
            });
            $menuEntry->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menuEntry)
                ->withProperties($data)
                ->log('ویرایش آیتم منو');
            alert()->success('موفق', 'با موفقیت انجام شد');
            return redirect(route('admin.menuentry.show', $menuEntry));
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
            'slug' => 'bail|nullable|string',
        ]);
        try {
            $menuEntry = MenuEntry::create([
                'name' => $data['name'],
                'slug' => $data['slug'] ?: '#',
                'is_parent' => true,
                'icon' => null,
                'author_id' => auth()->id(),
                'order' => null,
                'parent_id' => null,
                'is_active' => false,
            ]);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($menuEntry)
                ->withProperties($data)
                ->log('ساخت آیتم منو جدید');
            alert()->success('موفق', 'آیتم منو جدید ساخته شد');
            return redirect(route('admin.menuentry.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }
}
