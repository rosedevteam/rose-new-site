<?php


if (!function_exists('getEditRouteByType')) {
    function getEditRouteByType($type, $id)
    {
        if (is_null($id)) {
            return "";
        }
        $type = strtolower(array_reverse(explode('\\', $type))[0]);
        if (in_array($type, ['category', 'dailyreport', 'menu'])) {
            return "";
        }
        return route('admin.' . $type . 's.edit', $id, false);
    }

}

if (!function_exists('getModelRouteByType')) {
    function getModelTitleByType($type, $id)
    {
        $name = "";
        if (is_null($id)) return $name;
        $type = strtolower(array_reverse(explode('\\', $type))[0]);
        switch ($type) {
            case 'user':
                $name = \Modules\User\Models\User::find($id)?->name() ?: "";
                break;
            case 'discount':
                $name = \Modules\Discount\Models\Discount::find($id)?->code ?: "";
                break;
            case 'post':
                $name = \Modules\Post\Models\Post::find($id)?->title ?: "";
                break;
            case 'product':
                $name = \Modules\Product\Models\Product::find($id)?->title ?: "";
                break;
            case 'joboffer':
                $name = \Modules\JobOffer\Models\JobOffer::find($id)?->title ?: "";
                break;
            case 'jobapplication':
                $name = \Modules\JobApplication\Models\JobApplication::find($id)?->full_name ?: "";
                break;
            case 'order':
                $name = \Modules\Order\Models\Order::find($id)?->user?->name() ?: "";
                break;
            case 'menu':
                $name = \Modules\Menu\Models\Menu::find($id)?->title ?: "";
                break;
            case 'dailyreport':
                $name = \Modules\DailyReport\Models\DailyReport::find($id)?->title ?: "";
                break;
            case 'comment':
                $name = \Modules\Comment\Models\Comment::find($id)?->user?->name() ?: "";
                break;
            case 'category':
                $name = \Modules\Category\Models\Category::find($id)?->name ?: "";
                break;
            case 'studentreport':
                $name = \Modules\StudentReport\Models\StudentReport::find($id)?->date ?: "";
                break;
        }
        return $name;
    }
}

if (!function_exists('sendVerifySms')) {
    function sendVerifySms($phone , $code)
    {
        try {
            $template = "verify";
            //Send null for tokens not defined in the template
            //Pass token10 and token20 as parameter 6th and 7th

            $kavenegar = new \Kavenegar\KavenegarApi(config('services.sms.api'));
            return $kavenegar->VerifyLookup($phone, $code, '', '', $template);
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }

    }
}
