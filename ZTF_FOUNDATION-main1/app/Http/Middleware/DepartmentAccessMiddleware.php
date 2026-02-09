<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Si l'utilisateur est un super admin, on le laisse passer
        if (Auth::user()->isSuperAdmin()) {
            return $next($request);
        }

        // Récupérer l'ID du service depuis la route si disponible
        $serviceId = $request->route('service');

        // Si on a un ID de service
        if ($serviceId) {
            $service = Service::find($serviceId);
            
            // Si le service n'existe pas, rediriger avec une erreur
            if (!$service) {
                return redirect()->route('services.index')
                    ->with('error', 'Service introuvable.');
            }

            // Vérifier si l'utilisateur est un chef de département et si le service appartient à son département
            if (Auth::user()->isAdmin2() && $service->department_id === Auth::user()->department_id) {
                return $next($request);
            }

            // Si l'accès n'est pas autorisé
            return redirect()->route('services.index')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à ce service.');
        }

        // Pour la liste des services (index)
        if ($request->route()->getName() === 'services.index') {
            // Si c'est un chef de département, on le laisse passer
            // La requête sera filtrée dans le contrôleur pour ne montrer que ses services
            if (Auth::user()->isAdmin2()) {
                return $next($request);
            }
        }

        // Pour la création de service
        if ($request->route()->getName() === 'services.create') {
            // Seul un chef de département peut créer un service
            if (Auth::user()->isAdmin2()) {
                return $next($request);
            }
        }

        // Si aucune condition n'est remplie, rediriger avec un message d'erreur
        return redirect()->route('services.index')
            ->with('error', 'Vous n\'avez pas les permissions nécessaires pour effectuer cette action.');
    }
}