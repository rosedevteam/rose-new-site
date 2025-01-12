<?php

namespace Modules\StudentReport\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Modules\StudentReport\Models\StudentReport;

class StudentReportController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('تحلیل های دانشپذیران');
        $studentReports = StudentReport::where('status', 'approved')->orderBy('created_at', 'desc')->get();

        return view('studentreport::front.index', compact('studentReports'));
    }

    public function show(StudentReport $studentReport)
    {
        if ($studentReport->status != 'approved') {
            abort(404);
        }

        $filePath = storage_path('app/private/student-reports/' . $studentReport->analysis);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404);
    }
}
