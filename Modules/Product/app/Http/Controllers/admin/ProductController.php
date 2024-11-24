<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ProductController extends Controller
{
    public function index(): View|Factory|Application
    {
        Gate::authorize('view-products');
        return view('product::admin.index');
    }
}
