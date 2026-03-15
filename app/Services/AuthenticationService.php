<?php

namespace App\Services;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthenticationService
{
    protected $roleService;
    protected $userService;
    protected $departmentService;

    public function __construct(
        RoleManagementService $roleService,
        UserManagementService $userService,
        DepartmentService $departmentService
    ) {
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->departmentService = $departmentService;
    }

    /**
     * Authentifie un utilisateur ou le crée s'il n'existe pas
     * 
     * @param Request $request
     * @return User|null
     */
    public function authenticate(Request $request)
    {
        try {
            $existingUser = $this->userService->findByEmailOrMatricule(
                $request->email,
                $request->matricule
            );

            if ($existingUser) {
                return $this->authenticateExistingUser($existingUser, $request);
            }

            return $this->createAndAuthenticateNewUser($request);

        } catch (Exception $e) {
            Log::error('Authentication error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Authentifie un utilisateur existant
     * 
     * @param User $user
     * @param Request $request
     * @return User|null
     */
    protected function authenticateExistingUser(User $user, Request $request)
    {
        // Vérifier le mot de passe
        if (!$this->validatePassword($request->password, $user->password)) {
            throw new Exception('Mot de passe incorrect');
        }

        // Vérifier la correspondance email/matricule
        if (!$this->validateUserCredentials($user, $request)) {
            throw new Exception('Le matricule et l\'email ne correspondent pas au même compte');
        }

        // Mettre à jour les timestamps de connexion
        $this->updateLoginTimestamps($user);

        // Assigner le rôle Staff si nécessaire
        if ($this->userService->isStaffMatricule($user->matricule)) {
            $this->roleService->assignRoleToUser($user, 'F');
        }

        // Traiter le département si nécessaire
        $this->processDepartmentIfNeeded($user, $request);

        return $user;
    }

    /**
     * Crée et authentifie un nouvel utilisateur
     * 
     * @param Request $request
     * @return User
     */
    protected function createAndAuthenticateNewUser(Request $request)
    {
        $matricule = $request->matricule;

        // Générer un matricule pour le staff
        if ($this->userService->isStaffMatricule($matricule)) {
            $matricule = $this->userService->generateMatriculeStaff();
        }

        // Valider le département si c'est un chef de département
        if ($this->isDepartmentHead($matricule)) {
            $this->validateDepartmentInput($request);
        }

        // Créer l'utilisateur
        $user = User::create([
            'matricule' => $matricule,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'registered_at' => now(),
            'last_login_at' => now(),
            'last_activity_at' => now(),
            'last_seen_at' => now(),
            'is_online' => true,
        ]);

        // Assigner le rôle Staff
        if ($this->userService->isStaffMatricule($matricule)) {
            $this->roleService->assignRoleToUser($user, 'F');
            Log::info('Rôle Staff assigné à l\'utilisateur: ' . $user->matricule);
        }

        // Traiter le département
        if ($this->isDepartmentHead($matricule)) {
            try {
                $this->processDepartmentHead($user, $request);
            } catch (Exception $e) {
                $user->delete();
                throw $e;
            }
        }

        return $user;
    }

    /**
     * Valide le mot de passe
     * 
     * @param string $inputPassword
     * @param string $hashedPassword
     * @return bool
     */
    protected function validatePassword($inputPassword, $hashedPassword)
    {
        return Hash::check($inputPassword, $hashedPassword);
    }

    /**
     * Valide la correspondance des credentials utilisateur
     * 
     * @param User $user
     * @param Request $request
     * @return bool
     */
    protected function validateUserCredentials(User $user, Request $request)
    {
        return !($user->email !== $request->email && $user->matricule !== $request->matricule);
    }

    /**
     * Met à jour les timestamps de connexion
     * 
     * @param User $user
     * @return void
     */
    protected function updateLoginTimestamps(User $user)
    {
        $user->update([
            'last_login_at' => now(),
            'last_activity_at' => now(),
            'last_seen_at' => now(),
            'is_online' => true,
        ]);
    }

    /**
     * Traite le département si nécessaire
     * 
     * @param User $user
     * @param Request $request
     * @return void
     */
    protected function processDepartmentIfNeeded(User $user, Request $request)
    {
        if ($this->isDepartmentHead($user->matricule) 
            && $request->has('department_name') 
            && $request->has('department_code')) {
            $this->processDepartmentHead($user, $request);
        }
    }

    /**
     * Traite un chef de département
     * 
     * @param User $user
     * @param Request $request
     * @return void
     */
    protected function processDepartmentHead(User $user, Request $request)
    {
        // Vérifier si le code existe déjà
        $existingDepartment = Department::where('code', strtoupper($request->department_code))->first();
        
        if ($existingDepartment) {
            throw new Exception('Ce code de département est déjà utilisé');
        }

        $result = $this->departmentService->processDepartmentHead(
            $user,
            $request->department_name,
            $request->department_code
        );

        if (!$result) {
            throw new Exception('Erreur lors de la création du département');
        }

        $department =  Department::where('code',strtoupper($request->department_code))->first();

        if($department){
            $department->update(['department_id' => $department->id]);
        }
       
    }

    /**
     * Valide les informations du département
     * 
     * @param Request $request
     * @return void
     */
    protected function validateDepartmentInput(Request $request)
    {
        if (!$request->has('department_name') || !$request->has('department_code')) {
            throw new Exception('Les informations du département sont requises');
        }
    }

    /**
     * Vérifie si le matricule est un chef de département
     * 
     * @param string $matricule
     * @return bool
     */
    protected function isDepartmentHead($matricule)
    {
        return strtoupper($matricule) === 'CM-HQ-CD';
    }
}