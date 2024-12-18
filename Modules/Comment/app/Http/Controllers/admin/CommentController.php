<?php

namespace Modules\Comment\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Modules\Comment\Models\Comment;
use Throwable;

class CommentController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('کامنت ها');
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
        $data = request()->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);
        try {
            $comment->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($comment)
                ->withProperties($data)
                ->log('ویرایش کامنت');
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
        $data = request()->validate([
            'content' => 'required|string',
        ]);
        try {
            $newComment = Comment::create([
                'content' => $data['content'],
                'commentable_id' => $comment->id,
                'commentable_type' => "\\Modules\\Comment\\Models\\Comment",
                'author_id' => auth()->id(),
                'status' => 'approved',
            ]);
            activity()
                ->causedBy(auth()->id())
                ->performedOn($comment)
                ->withProperties($newComment)
                ->log('ساخت پست');
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
            $comment->delete();
            activity()
                ->causedBy(auth()->id())
                ->performedOn($comment)
                ->withProperties($comment)
                ->log('حذف کامنت');
            alert()->success('موفق', 'کامنت با موفقیت حذف شد');
            return redirect(route('admin.comments.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

}
