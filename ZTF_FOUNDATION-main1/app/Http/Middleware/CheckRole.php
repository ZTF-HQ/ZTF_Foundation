<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleName, ?string $grade = null): Response
    {
        if (!Auth::check()) {
            abort(403, 'Access denied');
        }

        if (!Auth::user()->hasRole($roleName, $grade ? (int)$grade : null)) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}
