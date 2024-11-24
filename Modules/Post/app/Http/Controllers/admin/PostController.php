<?php

namespace Modules\Post\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;

class PostController extends Controller
{
    public function index()
    {
        Gate::authorize('view-posts');
        return view('post::admin.index');
    }
}
