<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('users.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function updateProfile(Request $request){
        $user=Auth::user();

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:30|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:10|unique:users,phone' 
        ]);

        $user->update($request->only(['name','email','phone']));
        return redirect()->back()->with('success','Profil mis a jour avec succes');
    }

    public function updatePassword(Request $request){
        $user=Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if(!Hash::check($request->current_password, $user->password)){
            return redirect()->back()->withErrors([
                'message' => 'Mot de passe incorrect'
            ])->withInput($request->except('password'));
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success','Mot de passe mis a jour avec succes');

    }

    public function destroy(){
        $user = Auth::user();
        $user->delete();
        return redirect()->route('staff.index')->with('succes','ouvrier supprime');
    }
}
