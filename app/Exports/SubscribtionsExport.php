<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubscribtionsExport implements FromView
{

    private $subs;

    public function __construct($subs)
    {
        $this->subs = $subs;
    }


    public function view(): View
    {
        return view('subscribtion::backend.export', [
            'subs' => $this->subs
        ]);
    }
}
