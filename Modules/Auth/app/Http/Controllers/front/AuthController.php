<?php

namespace Modules\Auth\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Modules\User\Models\User;

class AuthController extends Controller
{
    use SEOTools;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->seo()->setTitle('ورود به حساب کاربری');
        return view('auth::front.login');
    }

    public function auth(Request $request)
    {
        try {
            $validData = $request->validate([
                'phone' => ['required' , 'regex:/^09[0|1|2|3][0-9]{8}$/']
            ]);

            $user = User::where('phone' , $validData['phone'])->first();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'is_signed_up' => true,
                    'phone' => $validData['phone'],
                ] , 200);
            }else{
                return response()->json([
                    'success' => true,
                    'is_signed_up' => false,
                    'phone' => $validData['phone']
                ] , 200);
            }

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }

    }
}
