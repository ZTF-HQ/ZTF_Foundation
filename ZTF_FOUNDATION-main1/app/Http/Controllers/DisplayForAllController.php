<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DisplayForAllController extends Controller
{
    public function indexForDepts(){
        $allDepts=Department::orderByDesc('created_at')
                              ->get();
        
        return view('departments.indexDepts',compact('allDepts'));
    }
}
