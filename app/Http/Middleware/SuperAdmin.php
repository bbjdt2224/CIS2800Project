<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperAdmin
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

        if(Auth::user()->role == 'admin'){
            return redirect('admin/home');
        }

        return $next($request);
    }
}
