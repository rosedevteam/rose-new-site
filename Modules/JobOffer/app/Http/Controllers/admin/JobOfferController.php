<?php

namespace Modules\JobOffer\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\JobOffer\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('فرصت های شغلی');
        Gate::authorize('view-job-offers');
        try {

            $sort_direction = request('sort_direction', 'desc');
            $category = request('category', 'all');
            $categories = JobOffer::allCategories();
            $jobOffers = JobOffer::query();

            if($category != 'all') {
                $jobOffers = $jobOffers->whereRelation('categories', 'category_id', $category);
            }

            $jobOffers = $jobOffers->orderBy('created_at', $sort_direction);
            $jobOffers = $jobOffers->paginate(50);

            return view('joboffer::admin.index', compact('jobOffers', 'sort_direction', 'categories', 'category'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function create()
    {
        Gate::authorize('create-job-offers');
        try {
            $categories = JobOffer::allCategories();
            return view('joboffer::admin.create', compact('categories'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-job-offers');
        $data = request()->validate([
            'title' => 'bail|required|string|max:255',
            'content' => 'bail|required',
            'status' => 'bail|required|string',
            'type' => 'bail|required|string',
            'categories.*' => 'bail|required|exists:categories,id',
        ]);

        try {
            $jobOffer = JobOffer::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => auth()->id(),
                'status' => $data['status'],
                'type' => $data['type'],
            ]);
            $jobOffer->categories()->sync($data['categories']);
            $after = json_encode($jobOffer, JSON_UNESCAPED_UNICODE);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobOffer)
                ->withProperties(compact('after'))
                ->log('ساخت فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت ساخته شد');

            return redirect(route("admin.joboffers.edit", $jobOffer));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(JobOffer $joboffer)
    {
        Gate::authorize('view-job-offers');
        try {

            $categories = JobOffer::allCategories();

            return view('joboffer::admin.edit', compact('joboffer', 'categories'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(JobOffer $joboffer)
    {
        Gate::authorize('edit-job-offers');
        $data = request()->validate([
            'title' => 'bail|required|string|max:255',
            'content' => 'bail|required',
            'status' => 'bail|required|string',
            'categories.*' => 'bail|required|exists:categories,id',
            'type' => 'bail|required|string',
        ]);
        try {
            $data = array_filter($data, function ($value) {
                return !is_null($value);
            });

            $before = json_encode($data, JSON_UNESCAPED_UNICODE);
            $joboffer->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'status' => $data['status'],
                'type' => $data['type'],
            ]);
            $joboffer->categories()->sync($data['categories']);
            $after = json_encode($data, JSON_UNESCAPED_UNICODE);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($joboffer)
                ->withProperties(compact('before', 'after'))
                ->log('ویرایش فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت ویرایش شد');

            return redirect(route("admin.joboffers.edit", $joboffer));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(JobOffer $joboffer)
    {
        Gate::authorize('delete-job-offers');
        try {

            $before = json_encode($joboffer, JSON_UNESCAPED_UNICODE);
            $joboffer->delete();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(compact('before'))
                ->log('حذف فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت حذف شد');

            return redirect(route("admin.joboffers.index"));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

}
