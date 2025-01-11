<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guest()) {
            return redirect(route('admin.login'));
        }

        if (auth()->user()->hasPermissionTo('admin-panel')) {
            $next($request);
        }

        return redirect(route('index'));
    }
}
