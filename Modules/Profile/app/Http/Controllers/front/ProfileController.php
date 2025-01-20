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
        $this->seo()->setTitle('حساب کاربری');
        $products = auth()->user()->orders()->where('status' , 'completed')->with('products')->get()->pluck('products')->flatten()->unique('id');
        return view('profile::orders.my-courses' , compact('products'));
    }

    public function referrals()
    {
        $this->seo()->setTitle('رز کلاب');
        return view('profile::referrals.index');
    }

}
