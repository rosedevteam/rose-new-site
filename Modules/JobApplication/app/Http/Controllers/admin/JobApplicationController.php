<?php

namespace Modules\JobApplication\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\JobApplication\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index()
    {
        Gate::authorize('view-job-applications');
        try {
            $count = request('count', 50);
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
            $jobApplications = $jobApplications->orderBy('created_at', $sort_direction)->paginate($count);
            return view('jobapplication::admin.index', compact(
                'jobApplications',
                'count',
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
            return view('jobapplication::admin.show', compact('jobApplication'));
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
                'status' => 'required|string',
            ]);
            $jobApplication->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($jobApplication)
                ->withProperties($data)
                ->log('ویرایش رزومه');
            alert()->success('موفق', 'ویرایش رزومه با موفقیت انجام شد');
            return redirect(route('admin.jobapplications.show', $jobApplication));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

}
