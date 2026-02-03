<?php

namespace App\Http\Controllers;

use redirect;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('users', 'permissions')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'display_name'=>'required|string|max:20',
            'grade' => 'required|integer|min:0|max:10',
            'description' => 'required|string'
        ]);

        Role::create([
            'name' => $request->name,
            'display_name'=> $request->display_name,
            'grade' => $request->grade,
            'description' => $request->description
        ]);

        return redirect()->route('roles.index')->with('success','roles created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('users', 'permissions')->findOrFail($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role=Role::findOrFail($id);
        return view('roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'display_name'=>'required|string|max:20',
            'grade' => 'required|integer|min:0|max:10',
            'description'=>'required|string|max:250',
        ]);

        $roleData = Role::findOrFail($id);
        $roleData->update($request->only(['name', 'grade']));
        
        return redirect()->route('roles.index')->with('success',"le role {$roleData->name} a ete mis a jour avec succes ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roleData=Role::findOrFail($id);
        $roleData->delete();
        return redirect()->route('roles.index')->with('success','role supprime avec succes');
    }
}
