<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        // Charger les rôles liés pour lister avec les permissions
        $permissions = Permission::with('roles')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $roles = Role::all(); // Récupérer tous les rôles
        return view('permissions.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'roles' => 'array', // facultatif mais attendu
            'roles.*' => 'exists:roles,id'
        ]);

        // Création de la permission
        $permission = Permission::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Association des rôles choisis (si existants)
        if (!empty($validated['roles'])) {
            $permission->roles()->sync($validated['roles']);
        }

        // Redirection vers la liste
        return redirect()->route('permissions.index')
            ->with('success', 'Permission créée avec succès.');
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return redirect()->route('permissions.index')
                ->with('success', 'Permission supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')
                ->with('error', 'Impossible de supprimer cette permission car elle est utilisée.');
        }
    }
}
