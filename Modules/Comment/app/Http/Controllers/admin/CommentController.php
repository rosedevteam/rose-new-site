<?php

namespace Modules\Comment\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Comment\Models\Comment;
use Throwable;

class CommentController extends Controller
{
    public function index()
    {
        Gate::authorize('view-comments');
        $this->seo()->setTitle('کامنت ها');

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
                $comments = $comments->where('commentable_type', "\\Modules\\" . $type . "\\Models\\" . $type);
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
        } catch (Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(Comment $comment)
    {
        Gate::authorize('view-comments');
        try {
            return view('comment::admin.edit', compact('comment'));
        } catch (Throwable $th) {
            alert()->error("خطا");
            return back();
        }
    }

    public function update(Comment $comment)
    {
        Gate::authorize('edit-comments');
        try {

            $data = request()->validate([
                'status' => 'required|string|in:pending,approved,rejected',
            ]);

            $before = $comment->toArray();
            $comment->update($data);
            $after = $comment->toArray();

            self::log($comment, compact('before', 'after'), 'ویرایش کامنت');
            alert()->success("موفق", 'ویرایش با موفقیت انجام شد');

            return view('comment::admin.edit', compact('comment'));
        } catch (Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function reply(Comment $comment)
    {
        Gate::authorize('edit-comments');
        try {

            $data = request()->validate([
                'content' => 'required|string',
            ]);

            $newComment = Comment::create([
                'content' => $data['content'],
                'commentable_id' => $comment->id,
                'commentable_type' => "\\Modules\\Comment\\Models\\Comment",
                'user_id' => auth()->id(),
                'status' => 'approved',
            ]);
            $after = $newComment->toArray();

            self::log($newComment, compact('after'), 'پاسخ کامنت');
            alert()->success("موفق", 'کامنت با موفقیت ثبت شد');

            return redirect(route('admin.comments.edit', $comment));
        } catch (Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete-comments');
        try {

            $before = $comment->toArray();
            $comment->delete();

            self::log(null, compact('before'), 'حذف کامنت');
            alert()->success('موفق', 'کامنت با موفقیت حذف شد');

            return redirect(route('admin.comments.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

}
