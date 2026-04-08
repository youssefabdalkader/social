<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfUserRole
{
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check() && auth()->user()->role =='user') {
            return redirect('/');
        }

        return $next($request);
    }
}
