<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
       if(Auth::check() && Auth::user()->role==='super_admin'){
         return $next($request);
       }
       abort(403,'Access denied');

       
    }
}
