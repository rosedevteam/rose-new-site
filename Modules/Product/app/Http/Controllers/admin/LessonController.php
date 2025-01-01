<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Upload;
use Modules\Product\Models\Lesson;

class LessonController extends Controller
{
    use Upload;

    public function update()
    {
        try {
            $validData = request()->validate([
                'lessons' => 'required'
            ]);

            foreach ($validData['lessons'] as $index => $lesson) {

                $item = Lesson::whereId($index)->first();
                $item->update($lesson);
                if (isset($item['file'])) {
                    $item->update([
                        'file' => $lesson['file']
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
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ] , 400);
        }
    }
}
