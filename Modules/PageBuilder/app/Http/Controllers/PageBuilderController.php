<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $validData = $request->validate([
               'pagebuilder_type' => 'required',
               'pagebuilder_id' => 'required',
            ]);

            return view('pagebuilder::index');

        }catch (\Exception $exception){
            alert()->error($exception->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pagebuilder::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validData = $request->validate([
                'pagebuilder_type' => 'required',
                'pagebuilder_id' => 'required',
                'content' => 'required'
            ]);

            $item = $validData['pagebuilder_type']::where('id', $validData['pagebuilder_id'])->with('pagebuilder')->first();
            $item->pagebuilder()->create($validData);
            return response()->json([
               'success' => true,
               'message' => 'صفحه با موفقیت ذخیره شد'
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
    public function show($id)
    {
        return view('pagebuilder::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pagebuilder::edit');
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
