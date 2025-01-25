<?php

namespace Modules\Reserve\Http\Controllers\admin;

use App\Exports\ReserveExport;
use App\Http\Controllers\Controller;
use App\traits\ConvertNums;
use Gate;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Models\Product;
use Modules\Reserve\Models\Reserve;
use Modules\Reserve\Notifications\NotifyProductAvailable;
use Verta;

class ReserveController extends Controller
{
    use ConvertNums;

    public function index()
    {
        Gate::authorize('view-reserves');
        $reserves = Reserve::query();
        if ($key = \request('search')) {
            $reserves = $reserves->where('phone', 'like', "%$key%")->orWhere('name', 'like', "%$key%");
        }
        if (\request('filter')) {
            if ((\request('from')) && (\request('to'))) {
                $from = $this->dateFormatter($this->convertNums(\request('from')));
                $to = $this->dateFormatter($this->convertNums(\request('to')));
            } else {
                $from = $reserves->min('created_at');
                $to = $reserves->max('created_at');
            }

            if (\request('products')) {
                $reserves = Reserve::whereHas('products', function ($q) {
                    return $q->where('id', \request('products'));
                });
            }

            $reserves = $reserves->whereBetween('created_at', [$from, $to]);

        }
        $all_items = $reserves->get();
        $reserves = $reserves->latest()->paginate(50);

        $export = \request('export');

        if ($export != 0) {
            $date = Verta::instance(now())->format('y-m-d');
            return Excel::download(new ReserveExport($all_items), "reserves-$date.xlsx");
        }

        return view('reserve::admin.index', compact('reserves'));
    }

    public function dateFormatter($date)
    {
        $expire_date = explode('/', $date);

        $newDate = \Hekmatinasser\Verta\Facades\Verta::jalaliToGregorian(intval($expire_date[0]), intval($expire_date[1]), intval($expire_date[2]));
        return verta(implode('/', $newDate))->datetime();

    }

    public function notifyAvailable(Product $product)
    {
        Gate::authorize('send-reserves-notifications');
        try {
            $reserves = $product->reserves()->where('is_notified', 0)->get();
            foreach ($reserves as $reserve) {
                $reserve->user->notify(new NotifyProductAvailable($reserve->user->phone, $product->title));
            }
            alert()->success('موفق', 'با موفقیت ارسال شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }
}
