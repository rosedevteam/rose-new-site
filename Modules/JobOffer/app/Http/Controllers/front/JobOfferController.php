<?php

namespace Modules\JobOffer\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Modules\Category\Models\Category;
use Modules\JobOffer\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('همکاری با ما');
        $jobOffers = JobOffer::where('status', 'active')->get();

        $categories = Category::where('type', 'joboffer')->get();

        return view('joboffer::front.index', compact('jobOffers', 'categories'));
    }

    public function show(JobOffer $jobOffer)
    {
        if ($jobOffer->status == 'inactive') abort(404);
        $this->seo()->setTitle($jobOffer->title);

        return view('joboffer::front.show', compact('jobOffer'));
    }
}
