<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permissionName)
    {
        if (Auth::check() && Auth::user()->hasPermission($permissionName)){
            return $next($request);
        }

        abort(403,'Permission refused');
        
    }
}
