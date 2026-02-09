<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RoleAssignmentController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('super_admin');
    }*/

    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.role-assignments.index', compact('users', 'roles', 'permissions'));
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            $roles = Role::whereIn('id', $request->roles)->get();

            // Synchroniser les rôles (remplace tous les rôles existants)
            $user->attach($roles);

            DB::commit();

            Log::info('Roles assigned successfully', [
                'user_id' => $user->id,
                'roles' => $roles->pluck('name')
            ]);

            return redirect()->back()->with('success', 'Rôles assignés avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error assigning roles', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id
            ]);

            return redirect()->back()->with('error', 'Erreur lors de l\'assignation des rôles');
        }
    }

    public function assignPermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            $permissions = Permission::whereIn('id', $request->permissions)->get();

            // Synchroniser les permissions (remplace toutes les permissions existantes)
            $user->attach($permissions);

            DB::commit();

            Log::info('Permissions assigned successfully', [
                'user_id' => $user->id,
                'permissions' => $permissions->pluck('name')
            ]);

            return redirect()->back()->with('success', 'Permissions assignées avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error assigning permissions', [
                'error' => $e->getMessage(),
                'user_id' => $request->user_id
            ]);

            return redirect()->back()->with('error', 'Erreur lors de l\'assignation des permissions');
        }
    }

    public function getUserRolesAndPermissions(Request $request, $userId)
    {
        $user = User::with('roles', 'permissions')->findOrFail($userId);
        return response()->json([
            'roles' => $user->roles->pluck('id'),
            'permissions' => $user->permissions->pluck('id')
        ]);
    }
}