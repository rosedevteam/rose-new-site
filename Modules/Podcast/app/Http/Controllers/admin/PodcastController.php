<?php

namespace Modules\Podcast\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Upload;
use Gate;
use Modules\Podcast\Models\Podcast;

class PodcastController extends Controller
{
    use Upload;

    public function index()
    {
        Gate::authorize('view-podcasts');
        $podcasts = Podcast::query()->orderByDesc('created_at')->paginate(50);
        return view('podcast::admin.index', compact('podcasts'));
    }

    public function store()
    {
        Gate::authorize('create-podcasts');
        $validData = request()->validate([
            'title' => 'required',
            'image' => 'nullable',
        ]);
        try {
            $validData['image'] = $this->uploadFile($validData['image'], 'podcasts');
            $podcast = auth()->user()->podcasts()->create($validData);
            $after = $podcast->toArray();

            $this->log($podcast, compact('after'), 'ساخت پادکست');

            alert()->success('موفق', 'ساخت پادکست با موفقیت انجام شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(Podcast $podcast)
    {
        Gate::authorize('create-podcasts');
        try {
            return view('podcast::admin.edit', compact('podcast'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(Podcast $podcast)
    {
        Gate::authorize('delete-podcasts');
        try {
            $before = $podcast->toArray();
            $podcast->delete();

            $this->log(null, compact('before'), 'حذف پادکست');

            alert()->success('موفق', 'با موفقیت انجام شد');
            return back();
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
