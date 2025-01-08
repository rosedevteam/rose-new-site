<?php

namespace Modules\JobOffer\Http\Controllers\front;

use Modules\Category\Models\Category;
use Modules\JobOffer\Models\JobOffer;

class JobOfferController
{
    public function index()
    {
        $jobOffers = JobOffer::where('status', 'active')->get();

        $categories = Category::where('type', 'joboffer')->get();

        return view('joboffer::front.index', compact('jobOffers', 'categories'));
    }

    public function show(JobOffer $jobOffer)
    {
        if ($jobOffer->status == 'inactive') abort(404);

        return view('joboffer::front.show', compact('jobOffer'));
    }
}
