<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfUserRole
{
    public function handle(Request $request, Closure $next)
    {

        if (auth()->user()->hasRole('User') && auth()->user()->roles->count() === 1) {
            return redirect('/');
        }

        return $next($request);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> d37dc6dce32e1b9ddcf9acdfd06c355d47b264f7
