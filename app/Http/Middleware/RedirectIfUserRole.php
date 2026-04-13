<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfUserRole
{
    public function handle(Request $request, Closure $next)
    {

        // if (!auth()->user()->hasRole('admin')) {
        //     return redirect('/');
        // }

        return $next($request);
    }
}
