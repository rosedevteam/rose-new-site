<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubscriptionsExport implements FromView
{

    private $subs;

    public function __construct($subs)
    {
        $this->subs = $subs;
    }


    public function view(): View
    {
        return view('subscription::backend.subscriptionExport', [
            'subs' => $this->subs
        ]);
    }
}
