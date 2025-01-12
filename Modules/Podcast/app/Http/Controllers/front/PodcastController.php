<?php

namespace Modules\Podcast\Http\Controllers\front;

use App\Http\Controllers\Controller;

class PodcastController extends Controller
{
    public function index()
    {
        return view('podcast::front.index');
    }
}
