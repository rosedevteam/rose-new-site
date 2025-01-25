<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReserveExport implements FromView
{
    private $reserves;

    public function __construct($reserves)
    {
        $this->reserves = $reserves;
    }


    public function view(): View
    {
        return view('reserve::backend.export', [
            'reserves' => $this->reserves
        ]);
    }
}
