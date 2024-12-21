<?php

namespace Modules\JobOffer\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Modules\Category\Models\Category;
use Modules\JobOffer\Models\JobOffer;

class JobOfferController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('فرصت های شغلی');
        Gate::authorize('view-job-offers');
        try {

            $sort_direction = request('sort_direction', 'desc');
            $jobOffers = JobOffer::query();
            $jobOffers = $jobOffers->orderBy('created_at', $sort_direction);
            $jobOffers = $jobOffers->paginate(50);

            return view('joboffer::admin.index', compact('jobOffers', 'sort_direction'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function create()
    {
        Gate::authorize('create-job-offers');
        try {
            $categories = Category::where('name', 'team')->first()->children;
            return view('joboffer::admin.create', compact('categories'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-job-offers');
        try {
            $data = request()->validate([
                'title' => 'bail|required|string|max:255',
                'content' => 'bail|required',
                'team' => 'bail|required|string',
                'type' => 'bail|required|string',
                'status' => 'bail|required|string',
            ]);
            $jobOffer = JobOffer::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'type' => $data['type'],
                'user_id' => auth()->id(),
                'status' => $data['status'],
            ]);
            $jobOffer->categories()->attach($data['team']);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobOffer)
                ->withProperties([auth()->user(), $jobOffer, $data])
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
            $categories = Category::where('name', 'team')->first()->children;
            return view('joboffer::admin.edit', compact('joboffer', 'categories'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(JobOffer $joboffer)
    {
        Gate::authorize('edit-job-offers');
        try {
            $data = request()->validate([
                'title' => 'bail|nullable|string|max:255',
                'content' => 'bail|nullable',
                'team' => 'bail|nullable|string',
                'type' => 'bail|nullable|string',
                'status' => 'bail|nullable|string',
            ]);
            $data = array_filter($data, function ($value) {
                return !is_null($value);
            });

            $old = $joboffer->toArray();
            $joboffer->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'type' => $data['type'],
                'status' => $data['status'],
            ]);
            if (!is_null($data['team'])) {
                $data['team'] = Category::where('name', $data['team'])->first();
            }

            activity()
                ->causedBy(auth()->user())
                ->performedOn($joboffer)
                ->withProperties([auth()->user(), $joboffer, $old, $data])
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

            $joboffer->delete();

            activity()
                ->causedBy(auth()->user())
                ->performedOn($joboffer)
                ->withProperties([auth()->user(), $joboffer])
                ->log('حذف فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت حذف شد');

            return redirect(route("admin.joboffers.index"));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

}
