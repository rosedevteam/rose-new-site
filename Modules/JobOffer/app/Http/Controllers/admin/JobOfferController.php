<?php

namespace Modules\JobOffer\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Category\Models\Category;
use Modules\JobOffer\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index()
    {
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
            $categories = Category::where('group', 'team')->get();
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
            ]);
            $jobOffer = JobOffer::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'type' => $data['type'],
                'author_id' => auth()->id(),
            ]);
            $category = Category::where('id', $data['team'])->get();
            $jobOffer->categories()->attach($category);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobOffer)
                ->withProperties($data)
                ->log('ساخت فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت ساخته شد');
            return redirect(route("joboffer::admin.show", $jobOffer));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function show(JobOffer $jobOffer)
    {
        Gate::authorize('view-job-offers');
        try {
            return view('joboffer::admin.show', compact('jobOffer'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(JobOffer $jobOffer)
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
            if (!is_null($data['team'])) {
                $data['team'] = Category::where('name', $data['team'])->first();
            }
            $jobOffer->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobOffer)
                ->withProperties($data)
                ->log('ویرایش فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت ویرایش شد');
            return redirect(route("admin.joboffer.show", $jobOffer));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
    public function destroy(JobOffer $jobOffer)
    {
        Gate::authorize('delete-job-offers');
        try {
            $jobOffer->delete();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobOffer)
                ->log('حذف فرصت شغلی');
            alert()->success('موفق', 'فرصت شغلی با موفقیت حذف شد');
            return view('admin.joboffer.index');
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(JobOffer $jobOffer)
    {
        Gate::authorize('edit-job-offers');
        try {
            return view('joboffer::admin.edit', compact('jobOffer'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }
}
