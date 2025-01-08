<?php

namespace Modules\JobApplication\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\traits\Upload;
use Illuminate\Validation\Rules\File;
use Modules\JobApplication\Models\JobApplication;

class JobApplicationController extends Controller
{
    use Upload;

    public function store()
    {
        $validData = request()->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'resume' => [
                'required',
                File::types(['pdf'])
            ],
            'description' => 'nullable|string',
            'job_offer_id' => 'required|exists:job_offers,id',
        ]);
        // todo validate with jquery

        $path = $this->uploadFile($validData['resume'], '/job-applications', 'local');
        $validData['resume'] = $path;

        JobApplication::create($validData);

        alert()->success('موفق', 'رزومه شما با موفقیت ارسال شد');
        return back();
    }
}
