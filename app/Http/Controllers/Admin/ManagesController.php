<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\ScheduleCheck\FrequencyChecks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagesController extends Controller
{

    public function users($department_id)
    {
        $department = Departments::findOrFail($department_id);
        $users = User::where('is_admin', '!=', '1')
            ->where('department_id', $department_id)
            ->paginate(10);
        return view('admin.department.manage.users.index', compact('department', 'users'));
    }

    public function resinApp($department_id)
    {
        $department = Departments::findOrFail($department_id);

        return view('admin.department.manage.resinApp.index', compact('department'));
    }

    public function schedulePlan($department_id)
    {
        $department = Departments::findOrFail($department_id);
        $colorSet = [
            '1' => '#db9ece',
            '2' => '#aae9aa',
            '3' => '#82beff'
        ];

        return view('admin.department.manage.resinApp.schedulePlan.index', compact('department', 'colorSet'));
    }
}
