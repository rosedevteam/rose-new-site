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
                $comments = $comments->where('status', $status);
            }
            if ($type != 'all') {
                $comments = $comments->where('commentable_type', $type);
            } else {
                $comments = $comments->where('commentable_type', "!=", 'App\\Comment\\Models\\Comment');
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

    public function show(Comment $comment): Application|Factory|View
    {
        Gate::authorize('view-comments');
        try {
            return view('comment::admin.show', compact('comment'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Comment $comment): Application|Factory|View
    {
        Gate::authorize('edit-comments');
        $data = request()->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);
        try {
            $comment->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($comment)
                ->withProperties($data)
                ->log('updated comment');
            return view('comment::admin.show', compact('comment'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function store(): Application|Factory|View
    {
        Gate::authorize('edit-comments');
        $data = request()->validate([
            'content' => 'required|string',
            'commentable_id' => 'required|string',
            'commentable_type' => 'required|string',
        ]);
        try {
            $comment = Comment::create([
                'content' => $data['content'],
                'commentable_id' => $data['commentable_id'],
                'commentable_type' => $data['commentable_type'],
                'author_id' => auth()->id(),
                'status' => 'approved',
            ]);
            activity()
                ->causedBy(auth()->id())
                ->performedOn($comment)
                ->withProperties($data)
                ->log('created comment');
            return redirect(route('admin.comment.show', $comment));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

}
