<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Définir la date d'inscription
        $user->registered_at = $user->created_at;
        $user->saveQuietly();

        $user->syncRoleFromMatricule();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if($user->wasChanged('matricule')){
            $user->syncRoleFromMatricule();
        }
        // Ne pas mettre à jour info_updated_at pour les champs de suivi d'activité
        $excludedFields = [
            'last_activity_at',
            'last_login_at',
            'is_online',
            'last_seen_at',
            'remember_token',
            'updated_at'
        ];

        $changed = array_diff_key($user->getChanges(), array_flip($excludedFields));
        
        if (!empty($changed)) {
            $user->info_updated_at = now();
            $user->saveQuietly();
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Logique pour la suppression
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // Logique pour la restauration
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // Logique pour la suppression forcée
    }
}