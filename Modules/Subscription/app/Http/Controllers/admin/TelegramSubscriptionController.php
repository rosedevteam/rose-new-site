<?php

namespace Modules\Subscription\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\Models\TelegramSubscription;

class TelegramSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \Gate::authorize('manage-subscriptions');
        $subs = TelegramSubscription::query();

        if ($key = \request('search')) {
            $subs = $subs->where('name', 'like', "%$key%");
        }

        $subs = $subs->latest()->paginate(50);

        return view('subscription::admin.telegramSubscription.index' , compact('subs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subscription::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validData = $request->validate([
               'name' => 'required',
               'duration' => 'required',
               'product_id' => 'required',
               'price' => 'required|numeric',
            ]);

            $teleSub = TelegramSubscription::create($validData);
            return response()->json([
                'success' => true,
                'message' => 'اشتراک با موفقیت ساخته شد',
                'item' => $teleSub
            ]);
        }catch (\Exception $exception){
            alert()->error('خطا' , $exception->getMessage());
            return back();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('subscription::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegramSubscription $telegramSubscription)
    {
        try {
            return response()->json([
                'success' => true,
                'item' => $telegramSubscription
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ] , 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TelegramSubscription $telegramSubscription)
    {
        try {
            $validData = $request->validate([
                'name' => 'required',
                'duration' => 'required',
                'product_id' => 'required',
                'price' => 'required|numeric',
            ]);
            $telegramSubscription->update($validData);
            alert()->success('موفق' , 'اشتراک با موفقیت ویرایش شد شد');
            return back();
        }catch (\Exception $exception){
            alert()->error('خطا' , $exception->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegramSubscription $telegramSubscription)
    {
        try {
            $telegramSubscription->delete();
            alert()->success('موفق' , 'اشتراک با موفقیت حذف شد');
            return back();
        }catch (\Exception $exception){
            alert()->error('خطا' , $exception->getMessage());
            return back();
        }
    }
}
