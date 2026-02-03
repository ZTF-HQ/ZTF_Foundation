<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole($role)) {
            abort(403, 'Accès refusé. Vous n\'avez pas le rôle requis.');
        }

        return $next($request);
    }
}