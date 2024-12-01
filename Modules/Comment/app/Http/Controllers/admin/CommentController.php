<?php

namespace Modules\Comment\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Comment\Models\Comment;

class CommentController extends Controller
{
    public function index(): Application|Factory|View
    {
        Gate::authorize('view-comments');
        try {
            $sort_direction = request('sort_direction', 'desc');
            $search = request('search');
            $status = request('status', 'all');
            $type = request('type', 'all');
            $count = request('count', 50);
            $comments = Comment::query();
            if ($status != 'all') {
                $comments = $comments->where('approved', $status);
            }
            if ($type != 'all') {
                $comments = $comments->where('commentable_type', $type);
            }
            if ($search) {
                $comments = $comments->where('content', 'like', '%' . $search . '%');
            }
            $comments = $comments->orderBy('created_at', $sort_direction);
            $comments = $comments->paginate($count)->withQueryString();
            return view('comment::admin.index', [
                'comments' => $comments,
                'sort_direction' => $sort_direction,
                'search' => $search,
                'status' => $status,
                'type' => $type,
                'count' => $count,
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
