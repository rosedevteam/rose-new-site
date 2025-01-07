<?php

if (!function_exists("getClassNameLowerCase")) {
    function getClassNameLowerCase($namespace)
    {
        return strtolower(array_reverse(explode('\\', $namespace))[0]);
    }
}

if (!function_exists('getEditRouteByType')) {
    function getEditRouteByType($type, $id)
    {
        if (is_null($id)) return "";

        $type = getClassNameLowerCase($type);

        // return null for models that don't have edit pages
        if (in_array($type, ['category', 'dailyreport', 'menu'])) {
            return "";
        }

        return route('admin.' . $type . 's.edit', $id, false);
    }
}

if (!function_exists('getModelTitleByType')) {
    function getModelTitleByType($type, $id)
    {
        $name = "";

        if (is_null($id)) return $name;

        $type = getClassNameLowerCase($type);

        // add a case for every model
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

            case 'billing':
                $name = \Modules\User\Models\Billing::find($id)?->user?->name() ?: "";
                break;

            case 'attribute':
                $name = \Modules\Product\Models\Attribute::find($id)?->title ?: "";
                break;

            case "lesson":
                $name = \Modules\Product\Models\Lesson::find($id)?->title ?: "";
                break;

        }

        return $name;
    }
}
