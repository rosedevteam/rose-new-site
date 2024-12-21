<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;

class AdminController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('داشبورد');
        try {
            return view('admin::index');
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

}
