<?php

namespace Modules\Category\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Slug;
use Gate;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;

class CategoryController extends Controller
{
    use Slug;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view-categories');
        $this->seo()->setTitle('دسته بندی ها');
        try {

            $types = [
                'joboffer',
                'post',
                'product',
                'podcast'
            ];
            $type = request('type', 'all');
            $categories = Category::query();
            $parents = Category::all();

            if($type != 'all'){
                $categories = $categories->where('type', $type);
            }

            $categories = $categories->orderBy('created_at', 'desc')->paginate(500);
            return view('category::admin.index', compact('categories', 'type', 'types', 'parents'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-categories');
        $validData = $request->validate([
            'name' => 'required',
            'type_create' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'archive_slug' => "nullable|unique:categories,archive_slug",
        ]);
        try {
            $validData['archive_slug'] = self::getSlug($validData['archive_slug']);
            if(!is_null($validData['parent_id'])) {
                if (Category::where('id', $validData['parent_id'])->first()->type != $validData['type_create']) {
                    throw new \Exception();
                }
            }

            $category = Category::create([
                'name' => $validData['name'],
                'type' => $validData['type_create'],
                'user_id' => auth()->user()->id,
                'parent_id' => $validData['parent_id'],
                'archive_slug' => $validData['archive_slug'],
            ]);
            $after = $category->toArray();

            self::log($category, compact('after'), 'ساخت دسته بندی');
            alert()->success('موفق', 'کتگوری با موفقیت ساخته شد');

            return redirect(route('admin.categories.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category)
    {
        Gate::authorize('edit-categories');
        $validData = request()->validate([
            'name_edit' => 'required',
            'parent_id_edit' => 'nullable|exists:categories,id',
            'archive_slug_edit' => "nullable",
            'type_edit' => 'required',
        ]);
        try {
            $validData['archive_slug_edit'] = self::getSlug($validData['archive_slug_edit']);
            if (!is_null($validData['parent_id_edit'])) {
                if (Category::where('id', $validData['parent_id_edit'])->first()->type != $validData['type_edit']) {
                    throw new \Exception();
                }
            }

            $before = $category->toArray();
            $category->update([
                'name' => $validData['name_edit'],
                'archive_slug' => $validData['archive_slug_edit'],
                'parent_id' => $validData['parent_id_edit'],
            ]);
            $after = $category->toArray();

            self::log($category, compact('before', 'after'), 'ویرایش دسته بندی');
            alert()->success('موفق', 'کتگوری با موفقیت ساخته شد');

            return redirect(route('admin.categories.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete-categories');
        try {
            $before = $category->toArray();
            $category->delete();

            self::log(null, compact('before'), 'حذف دسته بندی');
            alert()->success('موفق', 'کنگوری با موفقیت حذف شد');

            return redirect(route('admin.categories.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }
}
