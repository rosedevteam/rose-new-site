<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Models\Attribute;
use Modules\Product\Models\Product;

class AttributeController extends Controller
{

    public function update(Request $request , Product $product)
    {
        try {
            $validData = $request->validate([
                'attributes' => 'required'
            ]);

            foreach ($product->attributes as $attribute) {

            }
        }catch(\Throwable $th) {

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        try {

            $attribute->delete();
            activity()
                ->withProperties([auth()->user()->name(), $attribute])
                ->log('حذف ویژگی محصول');
            return response()->json([
               'success' => true,
               'message' => 'ویژگی با موفقیت حذف شد'
            ] , 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ] , 400);
        }
    }
}
