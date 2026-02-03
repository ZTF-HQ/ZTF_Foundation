<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Vérifie si un utilisateur peut voir la liste des utilisateurs
     * Seuls les membres du comité directeur et les chefs de département peuvent voir la liste
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_users') || 
               $user->isAdmin1() || 
               $user->isAdmin2();
    }

    /**
     * Vérifie si un utilisateur peut voir un utilisateur spécifique
     * 
     * @param User $authUser L'utilisateur qui fait la demande
     * @param User $targetUser L'utilisateur à voir
     * @return bool
     */
    public function view(User $authUser, User $targetUser): bool
    {
        // Le comité directeur peut voir tous les utilisateurs
        if($authUser->isAdmin1()) {
            return true;
        }

        // Un chef de département peut voir le personnel de son département
        if($authUser->isAdmin2()) {
            return $authUser->department_id === $targetUser->department_id;
        }

        // Tout utilisateur (staff ou chef de service) peut voir son propre profil
        return $authUser->id === $targetUser->id;
    }

    /**
     * Détermine si l'utilisateur peut créer de nouveaux utilisateurs
     * Seuls les membres du comité directeur et les chefs de département peuvent créer des utilisateurs
     */
    public function create(User $authUser): bool
    {
        return $authUser->isAdmin1() || 
               ($authUser->isAdmin2() && $authUser->hasPermission('create_users'));
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un utilisateur
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // Le comité directeur peut modifier tous les utilisateurs
        if($authUser->isAdmin1()) {
            return true;
        }

        // Un chef de département peut modifier les utilisateurs de son département
        if($authUser->isAdmin2()) {
            return $authUser->department_id === $targetUser->department_id;
        }

        // Un utilisateur (staff ou chef de service) peut modifier son propre profil
        return $authUser->id === $targetUser->id;
    }

    /**
     * Vérifie si un utilisateur peut supprimer un utilisateur
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        // Le comité directeur peut supprimer n'importe quel utilisateur
        if($authUser->isAdmin1()) {
            return true;
        }

        // Un chef de département peut supprimer les utilisateurs de son département
        if($authUser->isAdmin2()) {
            return $authUser->department_id === $targetUser->department_id &&
                   $authUser->hasPermission('delete_users');
        }

        return false;
    }

    /**
     * Vérifie si un utilisateur peut restaurer un utilisateur supprimé
     * Seul le comité directeur peut restaurer des utilisateurs
     */
    public function restore(User $authUser, User $targetUser): bool
    {
        return $authUser->isAdmin1() && 
               $authUser->hasPermission('restore_users');
    }

    /**
     * Vérifie si un utilisateur peut forcer la suppression définitive d'un utilisateur
     * Seul le comité directeur peut effectuer cette action
     */
    public function forceDelete(User $authUser, User $targetUser): bool
    {
        return $authUser->isAdmin1() && 
               $authUser->hasPermission('force_delete_users');
    }

    //acces superadministrateur
    public function accessSuperAdmin( User $user){
        return $user->isSuperAdmin();
    }

    //acces admin
    public function accessAdmin1(User $user){
        return $user->isAdmin1();
    }

    public function accessAdmin2(User $user){
        return $user->isAdmin2();
    }

    //acces staff
    public function accessStaff(User $user){
        return $user->isStaff();
    }
}

