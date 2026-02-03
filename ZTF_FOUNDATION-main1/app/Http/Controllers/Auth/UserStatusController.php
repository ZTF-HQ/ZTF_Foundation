<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FirstRegistrationUser;
use Illuminate\Support\Facades\Session;

class UserStatusController extends Controller
{
    public function checkRegistrationStatus()
    {
        $hasRegistered = FirstRegistrationUser::where('email', Session::get('user_email'))->exists();
        return response()->json(['hasRegistered' => $hasRegistered]);
    }
}