<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserManagementService
{
    /**
     * Trouve un utilisateur par email ou matricule
     * 
     * @param string $email
     * @param string $matricule
     * @return User|null
     */
    public function findByEmailOrMatricule($email, $matricule)
    {
        return User::where('email', $email)
                   ->orWhere('matricule', $matricule)
                   ->first();
    }

    /**
     * Trouve un utilisateur par email
     * 
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Trouve un utilisateur par matricule
     * 
     * @param string $matricule
     * @return User|null
     */
    public function findByMatricule($matricule)
    {
        return User::where('matricule', $matricule)->first();
    }

    /**
     * Vérifie si un matricule est de type Staff (commence par STF)
     * 
     * @param string $matricule
     * @return bool
     */
    public function isStaffMatricule($matricule)
    {
        return str_starts_with(strtoupper($matricule), 'STF');
    }

    /**
     * Vérifie si un matricule est de type Chef de Département
     * 
     * @param string $matricule
     * @return bool
     */
    public function isDepartmentHeadMatricule($matricule)
    {
        $matricule = strtoupper($matricule);
        return $matricule === 'CM-HQ-CD' || preg_match('/^CM-HQ-(.*)-CD$/i', $matricule);
    }

    /**
     * Vérifie si un matricule est de type Comité Nehemie
     * 
     * @param string $matricule
     * @return bool
     */
    public function isCommitteeMemberMatricule($matricule)
    {
        return strtoupper($matricule) === 'CM-HQ-NEH';
    }

    /**
     * Vérifie si un matricule est de type Super Admin (SPAD)
     * 
     * @param string $matricule
     * @return bool
     */
    public function isSuperAdminMatricule($matricule)
    {
        return str_starts_with(strtoupper($matricule), 'CM-HQ-SPAD');
    }

    /**
     * Génère un matricule pour un Staff (format: STF0001, STF0002, ...)
     * 
     * @return string
     */
    public function generateMatriculeStaff()
    {
        $lastUser = User::where('matricule', 'LIKE', 'STF%')
                       ->orderBy('id', 'desc')
                       ->first();

        $lastNumber = 0;

        if ($lastUser && !empty($lastUser->matricule)) {
            if (preg_match('/(\d+)$/', $lastUser->matricule, $matches)) {
                $lastNumber = intval($matches[1]);
            }
        }

        $newMatricule = 'STF' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        Log::info('Nouveau matricule Staff généré: ' . $newMatricule);

        return $newMatricule;
    }

    /**
     * Génère un matricule pour un Super Admin (format: CM-HQ-SPAD-001, CM-HQ-SPAD-002, ...)
     * 
     * @return string
     */
    public function generateMatriculeSPAD()
    {
        $lastSpad = User::where('matricule', 'LIKE', 'CM-HQ-SPAD-%')
                       ->orderBy('id', 'desc')
                       ->first();

        $lastNumber = 0;

        if ($lastSpad && !empty($lastSpad->matricule)) {
            if (preg_match('/(\d+)$/', $lastSpad->matricule, $matches)) {
                $lastNumber = intval($matches[1]);
            }
        }

        $newMatricule = 'CM-HQ-SPAD-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        Log::info('Nouveau matricule SPAD généré: ' . $newMatricule);

        return $newMatricule;
    }

    /**
     * Compte le nombre de Staff actifs
     * 
     * @return int
     */
    public function countActiveStaff()
    {
        return User::where('matricule', 'LIKE', 'STF%')
                   ->where('is_online', true)
                   ->count();
    }

    /**
     * Compte le nombre de Chefs de Département
     * 
     * @return int
     */
    public function countDepartmentHeads()
    {
        return User::where('matricule', 'LIKE', 'CM-HQ-%-CD')
                   ->count();
    }

    /**
     * Compte le nombre de Membres du Comité
     * 
     * @return int
     */
    public function countCommitteeMembers()
    {
        return User::where('matricule', 'CM-HQ-NEH')
                   ->count();
    }

    /**
     * Récupère tous les Staff
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStaff()
    {
        return User::where('matricule', 'LIKE', 'STF%')
                   ->get();
    }

    /**
     * Récupère tous les Chefs de Département
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllDepartmentHeads()
    {
        return User::where('matricule', 'LIKE', 'CM-HQ-%-CD')
                   ->get();
    }

    /**
     * Récupère tous les Membres du Comité
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCommitteeMembers()
    {
        return User::where('matricule', 'CM-HQ-NEH')
                   ->get();
    }

    /**
     * Récupère tous les Super Admins
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSuperAdmins()
    {
        return User::where('matricule', 'LIKE', 'CM-HQ-SPAD-%')
                   ->get();
    }

    /**
     * Obtient le type de rôle basé sur le matricule
     * 
     * @param string $matricule
     * @return string
     */
    public function getRoleTypeFromMatricule($matricule)
    {
        $matricule = strtoupper($matricule);

        if ($this->isStaffMatricule($matricule)) {
            return 'staff';
        }

        if ($this->isDepartmentHeadMatricule($matricule)) {
            return 'department_head';
        }

        if ($this->isCommitteeMemberMatricule($matricule)) {
            return 'committee_member';
        }

        if ($this->isSuperAdminMatricule($matricule)) {
            return 'super_admin';
        }

        return 'user';
    }

    /**
     * Marque un utilisateur comme en ligne
     * 
     * @param User $user
     * @return bool
     */
    public function markAsOnline(User $user)
    {
        return $user->update([
            'is_online' => true,
            'last_activity_at' => now(),
            'last_seen_at' => now(),
        ]);
    }

    /**
     * Marque un utilisateur comme hors ligne
     * 
     * @param User $user
     * @return bool
     */
    public function markAsOffline(User $user)
    {
        return $user->update(['is_online' => false]);
    }

    /**
     * Met à jour la dernière activité d'un utilisateur
     * 
     * @param User $user
     * @return bool
     */
    public function updateLastActivity(User $user)
    {
        return $user->update([
            'last_activity_at' => now(),
            'last_seen_at' => now(),
        ]);
    }
}