<?php

namespace Modules\Comment\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;

class CommentController extends Controller
{
    public function index()
    {
        Gate::authorize('view-comments');
        return view('comment::admin.index');
    }
}
