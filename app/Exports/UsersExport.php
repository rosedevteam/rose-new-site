<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{

    private $users;

    public function __construct($users)
    {
        $this->users = $users;
    }


    public function view(): View
    {
        return view('user::admin.export', [
            'users' => $this->users
        ]);
    }
}
