<?php

namespace Modules\User\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Traits\AwardScore;
use App\Traits\ConvertNums;

class UserController extends Controller
{
    use ConvertNums, AwardScore;

    public function update()
    {
        $validData = request()->validate([
            'birthday' => 'nullable',
            'city' => 'nullable',
            'is_married' => 'nullable|boolean',
            'email' => 'nullable|email',
        ]);
        try {
            $scores = auth()->user()->scores();

            $this->checkAndAwardScore($scores, 'set-birthday');
            $this->checkAndAwardScore($scores, 'set-city');
            $this->checkAndAwardScore($scores, 'set-is_married');
            $this->checkAndAwardScore($scores, 'set-email');

            $validData['birthday'] = self::convertNums($validData['birthday']);

            $before = auth()->user()->toArray();
            auth()->user()->update($validData);
            $after = auth()->user()->toArray();

            $this->log(auth()->user(), compact('before', 'after'), 'ویرایش پروفایل توسط کاربر');

            alert()->success('موفق', 'اطلاعات شما با موفقیت ویرایش شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    private function checkAndAwardScore($scores, $description)
    {
        if (!$scores->where('log', 'set-birthday')->exists()) {
            $this->awardScore(50, 'set-birthday');
        }
    }

}
