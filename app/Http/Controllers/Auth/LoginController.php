<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationService;
use App\Services\RoleManagementService;
use App\Services\RedirectionService;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginController extends Controller
{
    protected $authService;
    protected $roleService;
    protected $redirectionService;
    protected $departmentService;

    /**
     * Constructeur avec injection de dépendances
     */
    public function __construct(
        AuthenticationService $authService,
        RoleManagementService $roleService,
        RedirectionService $redirectionService,
        DepartmentService $departmentService
    ) {
        $this->authService = $authService;
        $this->roleService = $roleService;
        $this->redirectionService = $redirectionService;
        $this->departmentService = $departmentService;
    }
    /**
     * Authentifie l'utilisateur
     */
    public function login(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string|max:50',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'department_name' => 'required_if:matricule,CM-HQ-CD|string|max:255',
            'department_code' => 'required_if:matricule,CM-HQ-CD|string|max:10'
        ]);

        // Initialiser les rôles
        $this->roleService->ensureAllRolesExist();

        // Authentifier l'utilisateur
        try {
            $user = $this->authService->authenticate($request);
        } catch (Exception $e) {
            return $this->handleAuthenticationError($request, $e);
        }

        // Connecter et rediriger
        Auth::login($user);

        if ($request->expectsJson()) {
            return response()->json($this->redirectionService->getJsonRedirect($user));
        }

        return $this->redirectionService->redirectWithMessage($user);
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->update(['is_online' => false]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Gère les erreurs d'authentification
     */
    protected function handleAuthenticationError(Request $request, Exception $e)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return back()->withErrors(['error' => $e->getMessage()])
                    ->withInput($request->except('password'));
    }
}
