<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isSuperAdmin()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Accès non autorisé. Seuls les super administrateurs peuvent accéder à cette section.');
        }

        return $next($request);
    }
}