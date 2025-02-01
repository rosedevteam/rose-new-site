<?php

namespace Modules\User\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Traits\ConvertNums;

class UserController extends Controller
{
    use ConvertNums;

    public function setBirthday()
    {
        if (auth()->user()->birthday) abort(403);
        try {
            $validData = request()->validate([
                'birthday' => 'required|string',
            ]);
            auth()->user()->update([
                'birthday' => self::convertNums($validData['birthday'])
            ]);
            return response()->json([
                'success' => true,
                'message' => 'عملیات با موفقیت انجام شد'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
