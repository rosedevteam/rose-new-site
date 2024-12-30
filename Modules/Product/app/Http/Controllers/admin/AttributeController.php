<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Upload;
use Illuminate\Http\Request;
use Modules\Product\Models\Attribute;
use Modules\Product\Models\Product;

class AttributeController extends Controller
{
    use Upload;
    public function update(Request $request , Product $product)
    {
        try {
            $validData = $request->validate([
                'attributes' => 'required'
            ]);

            foreach ($validData['attributes'] as $index => $attribute) {

                $attr = Attribute::whereId($index)->first();
                $attr->update($attribute);
                if (isset($attribute['icon'])) {
                    $path = $this->uploadFile($attribute['icon'] , "/products/attrs");
                    $attr->update([
                        'icon' => '/upload/' . $path
                    ]);
                }
            }

            alert()->success('ویرایش ویژگی ها با موفقیت انجام شد');

            return back();
        }catch(\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
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
