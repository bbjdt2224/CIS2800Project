<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role == 'employee'){
            return redirect('employee/home');
        }

        if(Auth::user()->role == 'superadmin'){
            return redirect('superadmin/home');
        }

        return $next($request);
    }
}
