<?php

namespace Modules\User\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Traits\ConvertNums;

class UserController extends Controller
{
    use ConvertNums;

    public function update()
    {
        $validData = request()->validate([
            'birthday' => 'nullable',
            'city' => 'nullable',
            'is_married' => 'nullable|boolean',
            'email' => 'nullable|email',
        ]);
        try {
            $points = 0;

            if (!is_null($validData['birthday'])) {
                if (auth()->user()->scores()->where('log', 'set-birthday')->get()->isEmpty()) {
                    auth()->user()->scores()->create([
                        'log' => 'set-birthday',
                        'score' => 50,
                        'type' => 'credit'
                    ]);
                    $points += 50;
                }
            }
            if (!is_null($validData['city'])) {
                if (auth()->user()->scores()->where('log', 'set-city')->get()->isEmpty()) {
                    auth()->user()->scores()->create([
                        'log' => 'set-city',
                        'score' => 50,
                        'type' => 'credit'
                    ]);
                    $points += 50;
                }
            }
            if (!is_null($validData['is_married'])) {
                if (auth()->user()->scores()->where('log', 'set-is_married')->get()->isEmpty()) {
                    auth()->user()->scores()->create([
                        'log' => 'set-is_married',
                        'score' => 50,
                        'type' => 'credit'
                    ]);
                    $points += 50;
                }
            }
            if (!is_null($validData['email'])) {
                if (auth()->user()->scores()->where('log', 'set-email')->get()->isEmpty()) {
                    auth()->user()->scores()->create([
                        'log' => 'set-email',
                        'score' => 50,
                        'type' => 'credit'
                    ]);
                    $points += 50;
                }
            }

            $validData['birthday'] = self::convertNums($validData['birthday']);

            $before = auth()->user()->toArray();
            auth()->user()->update($validData);
            $after = auth()->user()->toArray();

            $this->log(auth()->user(), compact('before', 'after'), 'ویرایش پروفایل توسط کاربر');

            if ($points != 0) {
                $score = $points;
                $message = 'اطلاعات شما با موفقیت ویرایش شد شما ' . $score . ' امتیاز گرفتید';
                toast($message, 'success', 'top-right');
            } else {
                toast('اطلاعات شما با موفقیت ویرایش شد', 'success', 'top-right');
            }
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }
}
