<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentHeadController extends Controller
{
    public function showAssignForm(Department $department)
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        
        // Filtrer les utilisateurs éligibles (ceux qui peuvent être chef de département)
        $eligibleUsers = $users->filter(function($user) use ($department) {
            return $user->isAdmin2() || $user->id === $department->head_id;
        });

        return view('admin.departments.assign-head', compact('department', 'eligibleUsers'));
    }

    public function assign(Request $request, Department $department)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        // Vérifier que l'utilisateur peut être chef de département
        $user = User::find($request->user_id);
        if (!$user->isAdmin2()) {
            return redirect()->back()->with('error', 'L\'utilisateur sélectionné ne peut pas être chef de département');
        }

        // Récupérer l'ancien chef s'il existe
        $oldHead = $department->head;

        // Si l'ancien chef existe, retirer son rôle de chef
        if ($oldHead) {
            $oldHead->roles()->where('code', 'CD')->delete(); // Retirer le rôle de chef par son code
            
            // Retirer l'accès à tous les services du département
            $oldHead->services()->detach($department->services->pluck('id'));
            
            // Retirer l'accès au département
            $oldHead->update(['department_id' => null]);
        }

        // Mettre à jour le département avec le nouveau chef
        $department->update([
            'head_id' => $request->user_id,
            'head_assigned_at' => now()
        ]);

        // Configurer le nouveau chef
        $newHead = User::find($request->user_id);
        
        // Assigner le rôle de chef de département par son code
        $cdRole = Role::where('code', 'CD')->first();
        if ($cdRole) {
            $newHead->roles()->syncWithoutDetaching([$cdRole->id]);
        }

        // Donner accès au département
        $newHead->update(['department_id' => $department->id]);
        $department->users()->attach($request->user_id);
        
        // Donner accès à tous les services du département
        $newHead->services()->syncWithoutDetaching($department->services->pluck('id'));

        return redirect()->back()->with('success', 'Chef de département assigné avec succès');
    }

    public function remove(Department $department)
    {
        // Récupérer l'ancien chef
        $oldHead = $department->head;

        if ($oldHead) {
            // Retirer le rôle de chef
            $oldHead->roles()->detach(2);
            
            // Retirer l'accès à tous les services du département
            $oldHead->services()->detach($department->services->pluck('id'));
        }

        // Retirer le chef du département
        $department->update([
            'head_id' => null,
            'head_assigned_at' => null
        ]);

        return redirect()->back()->with('success', 'Chef de département retiré avec succès');
    }
}