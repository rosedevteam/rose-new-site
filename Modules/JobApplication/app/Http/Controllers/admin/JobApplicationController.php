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
        $this->seo()->setTitle('رزومه ها');

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

    public function edit(JobApplication $jobapplication)
    {
        Gate::authorize('view-job-applications');
        try {
            return view('jobapplication::admin.edit', compact('jobapplication'));
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function update(JobApplication $jobapplication)
    {
        Gate::authorize('edit-job-applications');
        try {

            $data = request()->validate([
                'status' => 'required|string|in:accepted,rejected,pending',
            ]);

            $before = $jobapplication->toArray();
            $jobapplication->update($data);
            $after = $jobapplication->toArray();

            self::log($jobapplication, compact('before', 'after'), 'ویرایش رزومه');
            alert()->success('موفق', 'ویرایش رزومه با موفقیت انجام شد');

            return back();
        } catch (\Throwable $th) {
            alert()->error('خطا', $th->getMessage());
            return back();
        }
    }

    public function destroy(JobApplication $jobapplication)
    {
        Gate::authorize('delete-job-applications');
        try {
            $before = $jobapplication->toArray();
            $jobapplication->delete();

            self::log(null, compact('before'), 'حذف رزومه');
            alert()->success('موفق', 'پست با موفقیت حذف شد');

            return redirect(route('admin.jobapplications.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function getResume($id)
    {
        $jobApplication = JobApplication::find($id);
        $filePath = storage_path('app/private/' . $jobApplication->resume);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        abort(404);
    }

}
