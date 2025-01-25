<?php

namespace Modules\Subscription\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Subscription\Models\Subscription;
use Verta;

class SubscriptionController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-subscriptions');
        $subs = Subscription::query();

        if ($key = \request('search')) {
            $subs = $subs->where('name', 'like', "%$key%");
        }

        $subs = $subs->latest()->paginate(50);

        return view('subscription::admin.index', compact('subs'));
    }


    public function create()
    {
        return view('subscription::create');
    }


    public function store()
    {
        Gate::authorize('manage-subscriptions');
        try {
            $validData = request()->validate([
                'name' => 'required',
                'description' => 'nullable',
                'expire_date' => 'required'
            ]);
            $expire_date = explode('/', $validData['expire_date']);

            $newDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($expire_date[0]), intval($expire_date[1]), intval($expire_date[2]));

            $dateTime = verta(implode('/', $newDate))->datetime();

            $validData['expire_date'] = $dateTime;


            $sub = Subscription::create($validData);
            $after = $sub->toArray();

            $this->log($sub, compact('after'), 'ساخت اشتراک');
            return response()->json([
                'message' => 'اشتراک جدید با موفقیت افزوده شد',
                'status' => 'success',
                'item' => $sub,
                'expire_date' => Verta::instance($sub->expire_date)->formatJalaliDate()
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'مشکلی در اضافه کردن اشتراک وجود دارد',
                'status' => 'error',
            ], 422);
        }
    }


    public function show(Subscription $subscription)
    {
        Gate::authorize('manage-subscriptions');
        return view('subscription::show');
    }


    public function edit(Subscription $subscription)
    {
        Gate::authorize('manage-subscriptions');
        return response()->json([
            'status' => 'success',
            'item' => $subscription,
            'expire_date' => Verta::instance($subscription->expire_date)->formatJalaliDate()
        ]);
    }


    public function update(Subscription $subscription)
    {
        Gate::authorize('manage-subscriptions');
        try {

            $validData = request()->validate([
                'name' => 'required',
                'description' => 'nullable',
                'expire_date' => 'required'
            ]);

            $expire_date = explode('/', $validData['expire_date']);

            $newDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($expire_date[0]), intval($expire_date[1]), intval($expire_date[2]));

            $dateTime = verta(implode('/', $newDate))->datetime();

            $validData['expire_date'] = $dateTime;

            $before = $subscription->toArray();
            $subscription->update($validData);
            $after = $subscription->toArray();

            $this->log($subscription, compact('before', 'after'), 'ویرایش اشتراک');

            return response()->json([
                'status' => 'success',
                'message' => 'ویرایش با موفقیت انجام شد'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'مشکلی در ویرایش اشتراک وجود دارد',
                'status' => 'error',
            ], 422);
        }


    }


    public function destroy(Subscription $subscription)
    {
        Gate::authorize('manage-subscriptions');
        try {
            $before = $subscription->toArray();
            $subscription->delete();

            $this->log(null, compact('before'), 'حذف اشتراک');
            alert()->success('موفق', 'حذف با موفقیت انجام شد');
            return back();
        } catch (\Throwable $e) {
            alert()->error('مشکلی در حذف آیتم به وجود آمده است');
            return back();
        }
    }

}
