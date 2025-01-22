<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    private $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }


    public function view(): View
    {
        return view('order::backend.export', [
            'orders' => $this->orders
        ]);
    }
}
