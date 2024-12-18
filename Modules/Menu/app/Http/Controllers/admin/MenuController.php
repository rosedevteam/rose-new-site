<?php

namespace Modules\Menu\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Modules\Menu\Models\Menu;

class MenuController extends Controller
{

    use SEOTools;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->seo()->setTitle('همه منو ها');

        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->simplePaginate(50);
        return view('menu::admin.index' , compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->seo()->setTitle('ایجاد منوی جدید');

        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->simplePaginate(15);
        return view('menu::admin.create' , compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validData = $request->validate([
                'title' => 'required',
                'parent_id' => 'nullable',
                'link' => 'required',
                'order' => 'nullable',
                'icon' => 'nullable',
                'subtitle' => 'nullable'
            ]);
            auth()->user()->menus()->create([
                'title' => $validData['title'],
                'parent_id' => $validData['parent_id'],
                'link' => $validData['link'],
                'order' => $validData['order'],
                'icon' => $validData['icon'],
                'subtitle' => $validData['subtitle'],
                'author_id' => auth()->user()->id
            ]);
            alert()->success('منوی جدید با موفقیت ایجاد شد.');
            return back();
        }catch (\Throwable $th){
            alert()->error('خطا', $th->getMessage());
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
    public function destroy($id)
    {
        //
    }
}
