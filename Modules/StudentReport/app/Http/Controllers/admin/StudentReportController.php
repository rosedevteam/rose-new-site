<?php

namespace Modules\StudentReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Illuminate\Http\Request;
use Modules\StudentReport\Models\StudentReport;

class StudentReportController extends Controller
{
    use SEOTools;

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
        try {
            $validData = $request->validate([
                'company' => 'required',
                'date' => 'required',
                'analysis' => 'bail|required|file',
                'description' => 'nullable',
            ]);

            $name = 'student-report-' . now()->timestamp . "." . request()->file('analysis')->extension();
            request()->file('analysis')->storeAs('student-reports', $name);

            $analysis = auth()->user()->studentReports()->create([
                'company' => $validData['company'],
                'date' => $this->convertNums($validData['date']),
                'analysis' => $name,
                'description' => $validData['description'],
            ]);

            activity()
                ->withProperties([auth()->user()->name(), $analysis, $validData])
                ->log('ساخت تحلیل');
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

    protected static function convertNums($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        return str_replace($arabic, $num, $convertedPersianNums);
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
    public function edit($id)
    {
        return view('studentreport::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
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
