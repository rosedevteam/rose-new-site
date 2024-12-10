<?php

namespace Modules\JobOffer\Http\Controllers\admin;

use Gate;
use Modules\JobOffer\Models\JobApplication;

class JobApplicationController
{
    public function index()
    {
        Gate::authorize('view-job-applications');
        try {
            $count = request('count', 50);
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $search = request('search');
            $status = request('status', 'all');
            $jobApplications = JobApplication::query();
            if ($status != 'all') {
                $jobApplications = $jobApplications->where('status', $status);
            }
            if ($search) {
                $jobApplications = $jobApplications->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            }
            $jobApplications = $jobApplications->orderBy($sort_by, $sort_direction)->paginate($count);
            return view('joboffer::admin.jobapplication.index', compact(
                'jobApplications',
                'count',
                'sort_by',
                'sort_direction',
                'search',
                'status',
            ));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function show(JobApplication $jobApplication)
    {
        Gate::authorize('view-job-applications');
        try {
            return view('joboffer::admin.jobapplication.show', compact('jobApplication'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function update(JobApplication $jobApplication)
    {
        Gate::authorize('edit-job-applications');
        try {
            $data = request()->validate([
                'status' => 'required',
            ]);
            $jobApplication->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobApplication)
                ->withProperties($data)
                ->log('ویرایش رزومه');
            alert()->success('موفق', 'ویرایش رزومه با موفقیت انجام شد');
            return redirect(route('admin.joboffer.index'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }
}
