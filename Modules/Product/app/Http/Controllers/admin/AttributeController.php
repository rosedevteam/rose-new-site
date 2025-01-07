<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Upload;
use Modules\Product\Models\Attribute;
use Modules\Product\Models\Product;

class AttributeController extends Controller
{
    use Upload;

    public function update()
    {
        try {
            $validData = request()->validate([
                'attributes' => 'required'
            ]);

            $productId = 0;
            foreach ($validData['attributes'] as $index => $attribute) {

                $attr = Attribute::whereId($index)->first();
                $attr->update($attribute);
                if (isset($attribute['icon'])) {
                    $path = $this->uploadFile($attribute['icon'] , "/products/attrs");
                    $attr->update([
                        'icon' => '/upload/' . $path
                    ]);
                }

                $productId = $attr->product->id;
            }
            $after = $validData;

            self::log(Product::find($productId), compact('after'), 'ویرایش ویژگی پست');
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

            $before = $attribute->toArray();
            $attribute->delete();

            self::log(null, compact('before'), 'حذف ویژگی پست');
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
