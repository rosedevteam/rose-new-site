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
