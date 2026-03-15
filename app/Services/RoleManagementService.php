<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RoleManagementService
{
    protected function ensureStaffRoleExists()
    {
        $staffRole = Role::where('code', 'F')->first();
        
        if (!$staffRole) {
            Role::create([
                'name' => 'ouvrier',
                'code' => 'F',
                'grade' => 3,
                'display_name' => 'Staff',
                'description' => 'Rôle Staff - Ouvrier au Quartier General',
                'guard_name' => 'web'
            ]);
            Log::info('Rôle Staff créé automatiquement');
        }

        return $staffRole;
    }

    public function ensureRoleDeptHeadExists()
    {
        $deptHead = Role::where('code', 'CD')->first();

        if (!$deptHead) {
            Role::create([
                'name' => 'chef_departement',
                'display_name' => 'Chef de Departement',
                'code' => 'CD',
                'grade' => 2,
                'description' => 'Poste de chef de departement',
                'guard_name' => 'web'
            ]);
            Log::info('Role chef de departement cree avec succes');
        }

        return $deptHead;
    }

    public function ensureRoleCommitteeMemberExists()
    {
        $committeeMember = Role::where('code', 'NEH')->first();

        if (!$committeeMember) {
            Role::create([
                'name' => 'membre_comite_nehemie',
                'display_name' => 'Membre Comite Nehemie',
                'code' => 'NEH',
                'grade' => 1,
                'description' => 'Poste de membre du comite de nehemie',
                'guard_name' => 'web'
            ]);
            Log::info('Role membre comite de nehemie cree avec succes');
        }

        return $committeeMember;
    }

    /**
     * Assigne le rôle Staff à un utilisateur
     * 
     * @param User $user
     * @return void
     */
    protected function assignStaffRoleToUser(User $user)
    {
        // S'assurer que le rôle Staff existe
        $staffRole = $this->ensureStaffRoleExists();
        
        // Vérifier si l'utilisateur a déjà le rôle
        if (!$user->roles()->where('code', 'F')->exists()) {
            // Assigner le rôle Staff
            $user->roles()->attach($staffRole->id);
            Log::info('Rôle Staff assigné avec succès à l\'utilisateur: ' . $user->email);
        }
    }

    public function assignRoleToUser($user,$roleCode){
        $role = Role::where('code',$roleCode)->first();
        if(!$role){
            Log::warning("Role avec le code {$roleCode} non trouve");
            return false;
        }

        if(!$user->roles()->where('code',$roleCode)){
            $user->roles()->attach($role->id);
            Log::info("Role {$roleCode} assigne  a l'utilisateur {$user->name} {$user->email}  avec succes");
            return true;
        }

        return false;
    }

    public function ensureAllRolesExist(){
        $this->ensureStaffRoleExists();
        $this->ensureRoleDeptHeadExists();
        $this->ensureRoleCommitteeMemberExists();
    }
}