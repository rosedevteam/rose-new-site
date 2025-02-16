<?php

namespace Modules\Subscription\Http\Controllers\admin;

use App\Exports\TelegramChannelExport;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Subscription\Models\Telegram;

class TelegramController extends Controller
{

    //todo
    public function index()
    {
        $telegrams = Telegram::query();


        if ($key = \request('search')) {
            $telegrams = $telegrams->where('telegram_id' , 'like' , "%$key%")
                ->orWhere('phone' , 'like' , "%$key%")
                ->orWhere('fullname' , 'like' , "%$key%");
        }

        if (\request('filter')) {
            if (!is_null(\request('is_deleted'))) {
                $telegrams = $telegrams->where('is_deleted', \request('is_deleted'));
            }

            if (!is_null(\request('is_notified'))) {
                $telegrams = $telegrams->where('is_notified', \request('is_notified'));

            }
        }
        if (\request('export') != 0) {
            $date = Verta::instance(now())->format('y-m-d');
            return Excel::download(new TelegramChannelExport($telegrams->get()), "telegram-$date.xlsx");
        }
        $telegrams = $telegrams->latest()->paginate(50);

        return view('subscription::admin.telegram.index' , compact(['telegrams']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subscribtion::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validData = $request->validate([
                'fullname' => 'required',
                'telegram_id' => 'required',
                'phone' => 'required',
                'duration' => 'nullable',
                'start_date' => 'required',
                'end_date' => 'required',
                'desc' => 'nullable'
            ]);

            $start_date = explode('/', $validData['start_date']);

            $newStartDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($start_date[0]), intval($start_date[1]), intval($start_date[2]));

            $start_date = verta(implode('/', $newStartDate))->datetime();

            $validData['start_date'] = $start_date;

            $end_date = explode('/', $validData['end_date']);

            $newEndDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($end_date[0]), intval($end_date[1]), intval($end_date[2]));

            $end_date = verta(implode('/', $newEndDate))->datetime();

            $validData['end_date'] = $end_date;


            $tele = Telegram::create($validData);
            $start_date_persian = Verta::instance($tele->start_date)->formatJalaliDate();
            $end_date_persian = Verta::instance($tele->end_date)->formatJalaliDate();
            $tele->logs()->create([
                'log' => "اشتراک اضافه شد. مدت زمان:$tele->duration - تاریخ شروع:$start_date_persian - آیدی:$tele->telegram_id - تاریخ پایان:$end_date_persian -  توضیحات:$tele->desc "
            ]);
            return response()->json([
                'message' => 'اشتراک جدید با موفقیت افزوده شد',
                'status' => 'success',
                'item' => $tele,
                'start_date' => Verta::instance($tele->start_date)->formatJalaliDate(),
                'end_date' => Verta::instance($tele->end_date)->formatJalaliDate(),
                'is_notified' => "<span class='badge bg-warning'>ارسال نشده</span>",
                'is_deleted' => "<span class='badge bg-success'>عضو</span>",
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'مشکلی در ویرایش آیتم وجود دارد',
                'status' => 'error',
            ], 422);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('subscribtion::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tele = Telegram::find($id);
        return response()->json([
            'message' => 'اشتراک جدید با موفقیت افزوده شد',
            'status' => 'success',
            'item' => $tele,
            'start_date' => Verta::instance($tele->start_date)->formatJalaliDate(),
            'end_date' => Verta::instance($tele->end_date)->formatJalaliDate(),
            'is_notified' => $tele->is_notified
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Telegram $telegram)
    {

        try {
            $validData = $request->validate([
                'fullname' => 'required',
                'telegram_id' => 'required',
                'phone' => 'required',
                'duration' => 'nullable',
                'start_date' => 'required',
                'end_date' => 'required',
                'desc' => 'nullable',
                'is_notified' => 'required',
                'is_deleted' => 'nullable'
            ]);

            $start_date = explode('/', $validData['start_date']);

            $newStartDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($start_date[0]), intval($start_date[1]), intval($start_date[2]));

            $start_date = verta(implode('/', $newStartDate))->datetime();

            $validData['start_date'] = $start_date;

            $end_date = explode('/', $validData['end_date']);

            $newEndDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($end_date[0]), intval($end_date[1]), intval($end_date[2]));

            $end_date = verta(implode('/', $newEndDate))->datetime();

            $validData['end_date'] = $end_date;

            $telegram->update($validData);
            $start_date_persian = Verta::instance($telegram->start_date)->formatJalaliDate();
            $end_date_persian = Verta::instance($telegram->end_date)->formatJalaliDate();
            $telegram->logs()->create([
                'log' => "اشتراک ویرایش شد. مدت زمان:$telegram->duration - تاریخ شروع:$start_date_persian - آیدی:$telegram->telegram_id - تاریخ پایان:$end_date_persian -  توضیحات:$telegram->desc "
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'ویرایش با موفقیت انجام شد'
            ] , 200);
        }catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $tele = Telegram::find($id);
            $tele->update([
                'is_deleted' => 1,
                'deleted_date' => now()
            ]);

            $start_date_persian = Verta::instance($tele->start_date)->formatJalaliDate();
            $end_date_persian = Verta::instance($tele->end_date)->formatJalaliDate();

            $tele->logs()->create([
                'log' => "اشتراک حذف شد. مدت زمان:$tele->duration - تاریخ شروع:$start_date_persian - آیدی:$tele->telegram_id - تاریخ پایان:$end_date_persian -  توضیحات:$tele->desc "
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'آیتم با موفقیت حذف شد',
                'date' => Verta::instance(now())->formatJalaliDate()
            ]);

        }catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'مشکلی در حذف آیتم به وجود آمده است'
            ]);
        }
    }

    public function convert2persianNumbers($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        $string = str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }

    public function dateFormatter($date)
    {
        $expire_date = explode('/', $date);

        $newDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($expire_date[0]), intval($expire_date[1]), intval($expire_date[2]));
        $dateTime = verta(implode('/', $newDate))->datetime();
        return $dateTime;
    }
}
