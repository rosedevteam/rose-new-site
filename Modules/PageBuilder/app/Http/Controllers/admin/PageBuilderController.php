<?php

namespace Modules\PageBuilder\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\PageBuilder\Models\PageBuilder;

class PageBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('create-page');
        try {
            $validData = $request->validate([
                'pagebuilder_type' => 'required',
                'pagebuilder_id' => 'required',
            ]);

            return view('pagebuilder::create');

        }catch (\Exception $exception){
            alert()->error($exception->getMessage());
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-page');
        try {
            $validData = $request->validate([
                'pagebuilder_type' => 'required',
                'pagebuilder_id' => 'required',
                'content' => 'required'
            ]);

            $item = $validData['pagebuilder_type']::where('id', $validData['pagebuilder_id'])->with('pagebuilder')->first();
            $pagebuilder = $item->pagebuilder()->create($validData);
            return response()->json([
                'success' => true,
                'message' => 'صفحه با موفقیت ذخیره شد',
                'redirect' => route('admin.pagebuilder.edit' , $pagebuilder)
            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageBuilder $pagebuilder)
    {
        Gate::authorize('edit-page');
        return view('pagebuilder::edit' , compact('pagebuilder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageBuilder $pagebuilder)
    {
        Gate::authorize('edit-page');
        try {
            $validData = $request->validate([
                'content' => 'required'
            ]);
            $pagebuilder->update($validData);

            return response()->json([
                'success' => true,
                'message' => "صفحه  با موفقیت به روز رسانی شد"
            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
