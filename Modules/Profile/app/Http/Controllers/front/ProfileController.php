<?php

namespace Modules\Profile\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use SEOTools;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->seo()->setTitle('حساب کاربری');
        return view('profile::index');
    }

    public function orders()
    {
        $this->seo()->setTitle('سفارش ها');
        $orders = auth()->user()->orders()->latest()->get();
        return view('profile::orders.index' , compact('orders'));
    }

    public function myCourses()
    {
        //todo map orders to send licence with products
        $this->seo()->setTitle('حساب کاربری');
        $products = auth()->user()->orders()->where('status' , 'completed')->with('products')->get()->pluck('products')->flatten()->unique('id');
        return view('profile::orders.my-courses' , compact('products'));
    }

    public function referrals()
    {
        $this->seo()->setTitle('رز کلاب');
        return view('profile::referrals.index');
    }

    public function exchangeScoreToWallet(Request $request)
    {
        try {
            $validData = $request->validate([
                'score' => 'required'
            ]);
            $userScoresCredits = array_sum(auth()->user()->scores->where('type' , 'credit')->map(function ($score) {
                return $score->score;
            })->toArray());
            $userScoresDebits = array_sum(auth()->user()->scores->where('type' , 'debit')->map(function ($score) {
                return $score->score;
            })->toArray());
            $userScore = $userScoresCredits - $userScoresDebits;

            if ($validData['score'] <= $userScore) {
                $score = $validData['score'];
                $amount = $score * 30;
                auth()->user()->wallet->transactions()->create([
                    'description' => "انتقال $score امتیاز به کیف پول ",
                    'type' => 'credit',
                    'amount' => $amount,
                ]);

                auth()->user()->scores()->create([
                    'score' => $score,
                    'log' => "کسر $score امتیاز بابت تبدیل به کیف پول",
                    'type' => 'debit'
                ]);
                return response()->json([
                    'success' => true,
                    'message' => "عملیات با موفقیت انجام شد",
                    'balance' => auth()->user()->wallet->balance
                ], 200);
            }else {
                throw new \Exception('عدد انتخاب شده از امتیاز شما بیشتر است');
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
