<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NewVersion\ResinController;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Departments $department, Request $request)
    {
        $resinController = new ResinController;

        $machines = null;
        $lines = Lines::where('department_id', $department->id)->pluck('name', 'id');
        $line = null;

        $shift = $resinController->timeShift($department->id);

        if ($request->has('line_id')) {
            $lineId = $request->line_id;
            $line = Lines::findOrFail($lineId); // ดึงข้อมูลของไลน์ที่เลือก
        }

        return view('admin.department.dashboard.index', compact(
            'department',
            'lines',
            'machines',
            'line',
            'shift'
        ));
    }
}
