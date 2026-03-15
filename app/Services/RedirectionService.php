<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RedirectionService
{
    protected $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Obtient l'URL de redirection en fonction du matricule
     * 
     * @param string $matricule
     * @return string
     */
    public function getRedirectUrl($matricule)
    {
        $matricule = strtoupper($matricule);

        if ($this->userService->isStaffMatricule($matricule)) {
            return route('staff.dashboard');
        }

        if ($this->userService->isDepartmentHeadMatricule($matricule)) {
            return route('departments.dashboard');
        }

        if ($matricule === 'CM-HQ-CD') {
            return route('departments.choose');
        }

        if ($this->userService->isCommitteeMemberMatricule($matricule)) {
            return route('committee.dashboard');
        }

        if ($this->userService->isSuperAdminMatricule($matricule)) {
            return route('twoFactorAuth');
        }

        return route('home');
    }

    /**
     * Redirige l'utilisateur avec un message personnalisé
     * 
     * @param User $user
     * @return RedirectResponse
     */
    public function redirectWithMessage(User $user)
    {
        $matricule = strtoupper($user->matricule);
        $name = $user->name ?? '';
        $message = $this->getWelcomeMessage($matricule, $name);
        $url = $this->getRedirectUrl($matricule);

        return redirect($url)->with('success', $message);
    }

    /**
     * Obtient le message de bienvenue personnalisé
     * 
     * @param string $matricule
     * @param string $name
     * @return string
     */
    protected function getWelcomeMessage($matricule, $name = '')
    {
        $matricule = strtoupper($matricule);
        $suffix = $name ? ", {$name}" : "";

        if ($this->userService->isStaffMatricule($matricule)) {
            return "Bienvenue dans votre espace Staff{$suffix}";
        }

        if ($this->userService->isDepartmentHeadMatricule($matricule)) {
            return "Bienvenue dans votre espace Chef de Département{$suffix}";
        }

        if ($matricule === 'CM-HQ-CD') {
            return "Bienvenue Chef de Département{$suffix}. Veuillez choisir votre département";
        }

        if ($this->userService->isCommitteeMemberMatricule($matricule)) {
            return "Bienvenue dans votre espace cher Membre du Comité de Nehemie{$suffix}";
        }

        if ($this->userService->isSuperAdminMatricule($matricule)) {
            return "Veuillez vous authentifier pour accéder à votre espace Super Administrateur.";
        }

        return "Bienvenue{$suffix}";
    }

    /**
     * Obtient le type de tableau de bord pour l'utilisateur
     * 
     * @param string $matricule
     * @return string
     */
    public function getDashboardType($matricule)
    {
        $matricule = strtoupper($matricule);

        if ($this->userService->isStaffMatricule($matricule)) {
            return 'staff';
        }

        if ($this->userService->isDepartmentHeadMatricule($matricule)) {
            return 'department';
        }

        if ($matricule === 'CM-HQ-CD') {
            return 'department_selection';
        }

        if ($this->userService->isCommitteeMemberMatricule($matricule)) {
            return 'committee';
        }

        if ($this->userService->isSuperAdminMatricule($matricule)) {
            return 'two_factor_auth';
        }

        return 'home';
    }

    /**
     * Vérifie si l'utilisateur doit être redirigé vers 2FA
     * 
     * @param string $matricule
     * @return bool
     */
    public function requiresTwoFactorAuth($matricule)
    {
        return $this->userService->isSuperAdminMatricule($matricule);
    }

    /**
     * Obtient la route de redirection basée sur le rôle
     * 
     * @param string $matricule
     * @return string|null
     */
    public function getRouteByRole($matricule)
    {
        $matricule = strtoupper($matricule);

        $routes = [
            'staff' => 'staff.dashboard',
            'department' => 'departments.dashboard',
            'department_selection' => 'departments.choose',
            'committee' => 'committee.dashboard',
            'super_admin' => 'twoFactorAuth',
        ];

        $dashboardType = $this->getDashboardType($matricule);

        return $routes[$dashboardType] ?? 'home';
    }

    /**
     * Crée une redirection personnalisée avec tous les détails
     * 
     * @param User $user
     * @param string|null $customMessage
     * @return RedirectResponse
     */
    public function createCustomRedirect(User $user, $customMessage = null)
    {
        $message = $customMessage ?? $this->getWelcomeMessage($user->matricule, $user->name);
        $url = $this->getRedirectUrl($user->matricule);

        return redirect($url)->with('success', $message)->with('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'matricule' => $user->matricule,
            'dashboard_type' => $this->getDashboardType($user->matricule),
        ]);
    }

    /**
     * Redirige vers la page de login avec un message d'erreur
     * 
     * @param string $errorMessage
     * @return RedirectResponse
     */
    public function redirectToLoginWithError($errorMessage)
    {
        return redirect()->route('login')->withErrors(['error' => $errorMessage]);
    }

    /**
     * Redirige vers la page précédente avec un message
     * 
     * @param string $message
     * @param string $type
     * @return RedirectResponse
     */
    public function redirectBack($message, $type = 'success')
    {
        return back()->with($type, $message);
    }

    /**
     * Redirige vers une URL spécifique en JSON (pour AJAX)
     * 
     * @param User $user
     * @return array
     */
    public function getJsonRedirect(User $user)
    {
        return [
            'success' => true,
            'redirect' => $this->getRedirectUrl($user->matricule),
            'dashboard_type' => $this->getDashboardType($user->matricule),
            'message' => $this->getWelcomeMessage($user->matricule, $user->name),
        ];
    }
}