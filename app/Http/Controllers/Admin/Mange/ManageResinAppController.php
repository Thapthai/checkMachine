<?php

namespace App\Http\Controllers\Admin\Mange;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use App\Models\Resins;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\MagicConst\Line;

class ManageResinAppController extends Controller
{
    public function line($department_id)
    {
        $department = Departments::findOrFail($department_id);
        $lines = Lines::where('department_id', $department_id)->get();

        $colorSet = [
            '1' => '#db9ece',
            '2' => '#aae9aa',
            '3' => '#82beff'
        ];

        return view('admin.department.manage.resinApp.line.index', compact(
            'department',
            'lines',
            'colorSet'
        ));
    }

    public function machine(Departments $department, Lines $line, Request $request)
    {

        $machines = Machines::where('line_id', $line->id)->get();
        $searchMachine = $request->searchMachine;
        if ($searchMachine) {
            $machines = Machines::where('line_id', $line->id)
                ->where('name', 'LIKE', '%' . $searchMachine . '%')
                ->get();
        }

        return view('admin.department.manage.resinApp.line.machine.index', compact(
            'department',
            'line',
            'machines',
            'searchMachine'

        ));
    }

    public function resin(Departments $department, Lines $line, Machines $machine, Request $request)
    {
        $resins = Resins::where('machines_id', $machine->id)
            ->orderBy('sequence')
            ->get();

        $searchResin = $request->searchResin;
        if ($searchResin) {
            $resins = Resins::where('machines_id', $machine->id)
                ->orderBy('sequence')
                ->where('position', 'LIKE', '%' . $searchResin . '%')
                ->get();
        }

        return view('admin.department.manage.resinApp.line.machine.resin.index', compact(
            'department',
            'line',
            'machine',
            'resins',
            'searchResin'

        ));
    }

    public function schedule($department_id)
    {
        $department = Departments::findOrFail($department_id);
        $lines = Lines::where('department_id', $department_id)->get();

        return view('admin.department.manage.resinApp.index', compact(
            'department',
            'lines'
        ));
    }
}
