<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departement;
use App\Models\Role;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Vérifier l'authentification
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        
            $user = Auth::user();
            \Log::info('User authenticated:', ['user_id' => $user->id, 'name' => $user->name]);

            // Construire la requête de base
            $usersQuery = User::query();
            
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                $usersQuery->where('department_id', $user->department_id);
            }

            // Récupérer toutes les données nécessaires avec débogage
            $activeUsers = $this->getActiveUsers($usersQuery);
            \Log::info('Active Users retrieved:', ['count' => count($activeUsers)]);

            $todayLogins = $this->getTodayLogins($usersQuery);
            \Log::info('Today\'s Logins retrieved:', ['count' => count($todayLogins)]);

            $avgSessionTime = $this->getAverageSessionTime();
            \Log::info('Average Session Time:', $avgSessionTime);

            $totalRegistrations = $usersQuery->count();
            $departmentName = $user->department ? $user->department->name : 'Non assigné';

        // Données pour les graphiques
        $chartData = [
            'departmentData' => $this->getDepartmentStats($user),
            'roleData' => $this->getRoleStats($user),
            'serviceData' => $this->getServiceStats($user),
            'userActivity' => $this->getUserActivityStats($usersQuery, now()->subDays(7), now())
        ];

        // Debug: vérifier les données
        \Log::info('Active Users:', ['count' => count($activeUsers)]);

        // Retourner la vue avec toutes les variables
        return view('staff.statistique', compact(
            'activeUsers',
            'todayLogins',
            'avgSessionTime',
            'totalRegistrations',
            'departmentName',
            'chartData'
        ));
    }

    public function apiStats(Request $request)
    {
        $startDate = $request->input('start', Carbon::now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end', Carbon::now()->format('Y-m-d'));

        // Récupérer l'utilisateur connecté et son département
        $user = Auth::user();
        $departmentId = $user->department_id;

        // Filtrer les données en fonction des autorisations de l'utilisateur
        $usersQuery = User::query();
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $usersQuery->where('department_id', $departmentId);
        }

        $responseData = [
            'activeUsers' => $this->getActiveUsers($usersQuery),
            'todayLogins' => $this->getTodayLogins($usersQuery),
            'avgSessionTime' => $this->getAverageSessionTime(),
            'totalRegistrations' => $usersQuery->count(),
            'departmentData' => $this->getDepartmentStats($user),
            'roleData' => $this->getRoleStats($user),
            'serviceData' => $this->getServiceStats($user),
            'userActivity' => $this->getUserActivityStats($usersQuery, $startDate, $endDate)
        ];

        return response()->json($responseData);
    }



    private function getActiveUsers($usersQuery)
    {
        return $usersQuery
            ->select('users.*')
            ->selectRaw('EXTRACT(EPOCH FROM (last_activity_at - last_login_at))/60 as session_duration')
            ->whereNotNull('last_login_at')
            ->where('last_activity_at', '>=', Carbon::now()->subMinutes(15))
            ->orderBy('last_activity_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'department' => $user->department ? $user->department->name : 'Non assigné',
                    'last_login' => Carbon::parse($user->last_login_at)->format('H:i'),
                    'session_duration' => sprintf("%d:%02d", 
                        floor($user->session_duration/60),
                        floor($user->session_duration%60)
                    ),
                    'is_online' => Carbon::parse($user->last_activity_at)->gt(Carbon::now()->subMinutes(15))
                ];
            });
    }

    private function getTodayLogins($usersQuery)
    {
        return $usersQuery
            ->select('users.*', 'departements.name as department_name')
            ->leftJoin('departements', 'users.department_id', '=', 'departements.id')
            ->whereDate('last_login_at', Carbon::today())
            ->orderBy('last_login_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'department' => $user->department_name ?? 'Non assigné',
                    'login_time' => Carbon::parse($user->last_login_at)->format('H:i'),
                    'is_still_active' => Carbon::parse($user->last_activity_at)->gt(Carbon::now()->subMinutes(15))
                ];
            });
    }

    private function getAverageSessionTime()
    {
        $sessions = DB::table('users')
            ->select('users.name', 'departements.name as department_name')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM (last_activity_at - last_login_at))/60) as avg_duration')
            ->leftJoin('departements', 'users.department_id', '=', 'departements.id')
            ->whereNotNull('last_login_at')
            ->whereNotNull('last_activity_at')
            ->whereDate('last_login_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('users.name', 'departements.name')
            ->get()
            ->map(function ($session) {
                return [
                    'name' => $session->name,
                    'department' => $session->department_name ?? 'Non assigné',
                    'average_time' => sprintf("%d:%02d", 
                        floor($session->avg_duration/60),
                        floor($session->avg_duration%60)
                    )
                ];
            });

        $globalAverage = $sessions->avg(function ($session) {
            list($hours, $minutes) = explode(':', $session->average_time);
            return $hours * 60 + $minutes;
        });

        return [
            'sessions' => $sessions,
            'global_average' => sprintf("%d:%02d", floor($globalAverage/60), floor($globalAverage%60))
        ];
    }

    private function getDepartmentStats($user)
    {
        $query = Departement::withCount('users');
        
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $query->where('id', $user->department_id);
        }

        $stats = $query->get();

        return [
            'names' => $stats->pluck('name')->toArray(),
            'counts' => $stats->pluck('users_count')->toArray()
        ];
    }

    private function getRoleStats($user)
    {
        $query = Role::withCount(['users' => function($query) use ($user) {
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                $query->where('department_id', $user->department_id);
            }
        }]);

        $stats = $query->get();

        return [
            'names' => $stats->pluck('name')->toArray(),
            'counts' => $stats->pluck('users_count')->toArray()
        ];
    }

    private function getServiceStats($user)
    {
        $query = Service::withCount(['users' => function($query) use ($user) {
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                $query->where('department_id', $user->department_id);
            }
        }]);

        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $query->whereHas('departement', function($q) use ($user) {
                $q->where('id', $user->department_id);
            });
        }

        $stats = $query->get();

        return [
            'names' => $stats->pluck('name')->toArray(),
            'counts' => $stats->pluck('users_count')->toArray()
        ];
    }

    private function getUserActivityStats($usersQuery, $startDate, $endDate)
    {
        $stats = $usersQuery
            ->selectRaw('DATE(last_login_at) as date, COUNT(*) as count')
            ->whereBetween('last_login_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $counts = [];
        
        // Créer une période de dates
        $currentDate = Carbon::parse($startDate);
        $endDateTime = Carbon::parse($endDate);
        
        while ($currentDate <= $endDateTime) {
            $dateStr = $currentDate->format('Y-m-d');
            $stats_for_date = $stats->firstWhere('date', $dateStr);
            
            $dates[] = $currentDate->format('d/m');
            $counts[] = $stats_for_date ? $stats_for_date->count : 0;
            
            $currentDate->addDay();
        }

        return [
            'dates' => $dates,
            'counts' => $counts
        ];
    }
    
}


