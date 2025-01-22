<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TelegramChannelExport implements FromView
{
    private $telegrams;

    public function __construct($telegrams)
    {
        $this->telegrams = $telegrams;
    }


    public function view(): View
    {
        return view('subscription::backend.telegramExport', [
            'telegrams' => $this->telegrams
        ]);
    }
}
