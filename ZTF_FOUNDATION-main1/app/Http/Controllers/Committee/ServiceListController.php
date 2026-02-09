<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class ServiceListController extends Controller
{
    public function index()
    {
        // Get all departments with their services and count of users
        $departments = Department::with(['services' => function ($query) {
            $query->withCount('users');
        }])->get();

        return view('committee.services.service-list', compact('departments'));
    }

    
}