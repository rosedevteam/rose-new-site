<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TelegramCahnnelExport implements FromView
{
    private $telegrams;

    public function __construct($telegrams)
    {
        $this->telegrams = $telegrams;
    }


    public function view(): View
    {
        return view('subscribtion::backend.telegram.export', [
            'telegrams' => $this->telegrams
        ]);
    }
}
