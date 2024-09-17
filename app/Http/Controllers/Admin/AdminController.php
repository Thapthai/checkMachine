<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $departments = Departments::all();

        return view('admin.index', compact('departments'));
    }
    public function department($department_id)
    {
        $department = Departments::findOrFail($department_id);

        return view('admin.department.index', compact('department'));
    }
}
