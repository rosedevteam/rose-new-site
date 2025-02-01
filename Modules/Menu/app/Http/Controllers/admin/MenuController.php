<?php

namespace Modules\Menu\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Traits\Slug;
use Gate;
use Illuminate\Http\Request;
use Modules\Menu\Models\Menu;

class MenuController extends Controller
{
    use Slug;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('create-menus');
        try {
            $this->seo()->setTitle('همه منو ها');

            $menus = Menu::with('children')
                ->whereNull('parent_id')
                ->simplePaginate(50);
            return view('menu::admin.index' , compact('menus'));
        } catch (\Exception $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-menus');
        try {
            $this->seo()->setTitle('ایجاد منوی جدید');

            $menus = Menu::with('children')
                ->whereNull('parent_id')
                ->simplePaginate(15);
            return view('menu::admin.create' , compact('menus'));
        } catch (\Exception $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-menus');
        $validData = $request->validate([
            'title' => 'required',
            'parent_id' => 'nullable',
            'slug' => 'required',
            'order' => 'nullable',
            'icon' => 'nullable',
            'subtitle' => 'nullable'
        ]);
        try {
            $validData['slug'] = self::getSlug($validData['slug']);

            $menu = auth()->user()->menus()->create($validData);
            $after = $menu->toArray();

            self::log($menu, compact('after'), 'ساخت منو');
            alert()->success('منوی جدید با موفقیت ایجاد شد.');

            return back();
        }catch (\Throwable $th){
            alert()->error('خطا', $th->getMessage());
            return back();
        }

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('menu::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('menu::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Gate::authorize('delete-menus');
        try {

            $before = $menu->toArray();
            $menu->delete();

            self::log(null, compact('before'), 'حذف منو');
            alert()->success('موفق', 'منو با موفقیت حذف شد');

            return redirect(route('admin.menus.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }
}
