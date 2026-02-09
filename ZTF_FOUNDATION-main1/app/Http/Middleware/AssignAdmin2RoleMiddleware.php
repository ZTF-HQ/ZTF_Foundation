<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AssignAdmin2RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user && str_starts_with($user->matricule, 'CM-HQ-CD')) {
            $admin2Role = Role::where('name', 'admin-2')->first();
            
            if ($admin2Role && !$user->hasRole('admin-2')) {
                $user->assignRole($admin2Role);
            }
        }

        return $next($request);
    }
}