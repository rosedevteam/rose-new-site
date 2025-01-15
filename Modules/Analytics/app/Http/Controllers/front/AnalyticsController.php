<?php

namespace Modules\Analytics\Http\Controllers\front;

use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('analytics::front.index');
    }
}
