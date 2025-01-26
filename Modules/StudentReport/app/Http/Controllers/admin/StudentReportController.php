<?php

namespace Modules\StudentReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Traits\ConvertNums;
use Gate;
use Illuminate\Http\Request;
use Modules\StudentReport\Models\StudentReport;

class StudentReportController extends Controller
{
    use ConvertNums;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view-student-reports');
        try {
            $search = request('search');
            $count = request('count', 50);
            $sort_direction = request('sort_direction', 'desc');
            $status = request('status', 'all');
            $reports = StudentReport::query();
            if ($status != 'all') {
                $reports = $reports->where('status', $status);
            }
            if (!is_null($search)) {
                $reports = $reports->where('company', 'like', '%' . $search . '%')
                    ->orWhere('date', 'like', '%' . $search . '%');
            }
            $reports = $reports->orderBy('created_at', $sort_direction)->paginate($count);
            return view('studentreport::admin.index', compact('reports', 'search', 'count', 'status', 'sort_direction'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-student-reports');
        $validData = $request->validate([
            'company' => 'required',
            'date' => 'required',
            'analysis' => 'bail|required|file',
            'description' => 'nullable',
            'status' => 'required|in:approved,rejected,pending',
            'student_id' => 'required|exists:users,id',
        ]);
        try {

            $validData['date'] = $this->convertNums($validData['date']);
            $name = 'student-report-' . now()->timestamp . "." . request()->file('analysis')->extension();
            request()->file('analysis')->storeAs('student-reports', $name);

            $analysis = StudentReport::create([
                'company' => $validData['company'],
                'date' => $this->convertNums($validData['date']),
                'analysis' => $name,
                'description' => $validData['description'],
                'status' => $validData['status'],
                'student_id' => $validData['student_id'],
                'user_id' => auth()->user()->id,
            ]);
            $after = $analysis->toArray();

            self::log($analysis, compact('after'), 'ساخت تحلیل');
            alert()->success('موفق', 'تحلیل با موفقیت ساخته شد');

            return redirect(route('admin.studentreports.index'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-student-reports');
        try {
            return view('studentreport::admin.create');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('studentreport::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentReport $studentreport)
    {
        Gate::authorize('edit-student-reports');
        try {
            return view('studentreport::admin.edit', compact('studentreport'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentReport $studentreport)
    {
        Gate::authorize('edit-student-reports');
        $validData = request()->validate([
            'company' => 'required',
            'date' => 'required',
            'analysis' => 'bail|nullable|file',
            'description' => 'nullable',
            'status' => 'required|in:approved,rejected,pending',
        ]);
        try {

            $validData['date'] = $this->convertNums($validData['date']);
            if (!is_null(request()->file('analysis'))) {
                $name = 'student-report-' . now()->timestamp . "." . request()->file('analysis')->extension();
                request()->file('analysis')->storeAs('student-reports', $name);
            } else {
                $name = $studentreport->analysis;
            }

            $before = $studentreport->toArray();
            $studentreport->update([
                'company' => $validData['company'],
                'date' => $this->convertNums($validData['date']),
                'analysis' => $name,
                'description' => $validData['description'],
                'status' => $validData['status'],
            ]);
            $after = $studentreport->toArray();

            self::log($studentreport, compact('before', 'after'), 'ویرایش تحلیل');
            alert()->success('موفق', 'تحلیل با موفقیت ویرایش شد');

            return redirect(route('admin.studentreports.edit', $studentreport));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentReport $studentreport)
    {
        Gate::authorize('delete-student-reports');
        try {
            $before = $studentreport->toArray();
            $studentreport->delete();

            self::log($studentreport, compact('before'), 'حذف تحلیل');
            alert()->success('موفق', 'تحلیل با موفقیت حذف شد');

            return redirect(route('admin.studentreports.index'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function analysis(StudentReport $studentReport)
    {
        Gate::authorize('view-student-reports');
        try {
            $filePath = storage_path('app/private/student-reports/' . $studentReport->analysis);
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }
            return redirect(route('admin.studentreports.index'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return redirect(route('admin.studentreports.index'));
        }
    }
}
