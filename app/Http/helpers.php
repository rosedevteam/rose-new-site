<?php

if (!function_exists("getClassName")) {
    function getClassName($namespace)
    {
        return array_reverse(explode('\\', $namespace))[0];
    }
}

// todo add logging for WalletTransactions

if (!function_exists('getEditRouteByType')) {
    function getEditRouteByType($type, $id)
    {
        if (is_null($id)) return "";

        $type = getClassName($type);

        // return empty for models that don't have edit pages
        if (in_array($type, ['Category', 'DailyReport', 'Menu'])) {
            return "";
        }

        return route('admin.' . strtolower($type) . 's.edit', $id, false);
    }
}

if (!function_exists('getModelTitleByType')) {
    function getModelTitleByType($type, $id)
    {
        $name = "";

        if (is_null($id)) return $name;

        $type = getClassName($type);

        // add a case for every model
        switch ($type) {

            case 'User':
                $name = \Modules\User\Models\User::find($id)?->name() ?: "";
                break;

            case 'Discount':
                $name = \Modules\Discount\Models\Discount::find($id)?->code ?: "";
                break;

            case 'Post':
                $name = \Modules\Post\Models\Post::find($id)?->title ?: "";
                break;

            case 'Product':
                $name = \Modules\Product\Models\Product::find($id)?->title ?: "";
                break;

            case 'JobOffer':
                $name = \Modules\JobOffer\Models\JobOffer::find($id)?->title ?: "";
                break;

            case 'JobApplication':
                $name = \Modules\JobApplication\Models\JobApplication::find($id)?->full_name ?: "";
                break;

            case 'Order':
                $name = \Modules\Order\Models\Order::find($id)?->user?->name() ?: "";
                break;

            case 'Menu':
                $name = \Modules\Menu\Models\Menu::find($id)?->title ?: "";
                break;

            case 'DailyReport':
                $name = \Modules\DailyReport\Models\DailyReport::find($id)?->title ?: "";
                break;

            case 'Comment':
                $name = \Modules\Comment\Models\Comment::find($id)?->user?->name() ?: "";
                break;

            case 'Category':
                $name = \Modules\Category\Models\Category::find($id)?->name ?: "";
                break;

            case 'StudentReport':
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
