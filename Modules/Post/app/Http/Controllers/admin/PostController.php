<?php

namespace Modules\Post\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        Gate::authorize('view-posts');
        $sort_by = request('sort_by');
        $sort_direction = request('sort_direction', 'asc');
        $search = request('search');
        $count = request('count', 10);
        $status = request('status', 'all');
        $comment_status = request('comment_status', true);
        $posts = Post::query();
        if ($status !== 'all') {
            $posts = $posts->where('status', $status);
        }
        if ($comment_status !== 'all') {
            $posts = $posts->where('comment_status', $comment_status);
        }
        if ($search) {
            $posts = $posts->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        }
        if ($sort_by || $sort_direction) {
            $posts = $posts->orderBy($sort_by, $sort_direction);
        }
        $posts = $posts->paginate($count)->withQueryString();
        return view('post::admin.index', [
            'posts' => $posts,
            'sort_by' => $sort_by,
            'sort_direction' => $sort_direction,
            'status' => $status,
            'comment_status' => $comment_status,
            'search' => $search,
            'count' => $count,
        ]);
    }

    public function show(Post $post)
    {
        Gate::authorize('view-posts');
    }
}
