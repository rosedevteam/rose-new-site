<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Upload;
use Illuminate\Http\Request;
use Modules\Product\Models\Lesson;
use Modules\Product\Models\Product;

class LessonController extends Controller
{
    use Upload;
    public function update(Request $request , Product $product)
    {
        try {
            $validData = $request->validate([
                'lessons' => 'required'
            ]);

            foreach ($validData['lessons'] as $index => $lesson) {

                $item = Lesson::whereId($index)->first();
                $item->update($lesson);
                if (isset($item['file'])) {
                    $item->update([
                        'file' => $validData['file']
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
    public function destroy(Lesson $lesson)
    {
        try {

            $lesson->delete();
            activity()
                ->withProperties([auth()->user()->name(), $lesson])
                ->log('حذف درس از محصول');
            return response()->json([
                'success' => true,
                'message' => 'درس با موفقیت حذف شد'
            ] , 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ] , 400);
        }
    }
}
