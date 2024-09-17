<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Lines;
use App\Models\Resin_records;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LinesController extends Controller
{

    public function index($department_id, $onshift, $selected, $shiftDate,  Request $request)
    {
        $department = Departments::findOrFail($department_id);
        $lines = Lines::where('department_id', $department_id)->get();

        return view('lines.index', compact(
            'department',
            'onshift',
            'selected',
            'lines',
            'shiftDate'
        ));
    }

    public function create()
    {
        //
    }


    public function store($department_id, Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        Lines::create([
            'department_id' => $department_id,
            'name' => $validatedData['name'],
            'detail' => $validatedData['detail'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->back()->with('success', 'เพิ่มไลน์ผลิตสำเร็จ');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update($department_id,  Request $request, Lines $line)
    {
        $line->update($request->all());
        return redirect()->back()->with('success', 'แก้ไขสำเร็จ');
    }

    public function destroy($department_id, Request $request, Lines $line)
    {

        foreach ($line->machines as $machine) {
            foreach ($machine->resins as $resin) {
                foreach ($resin->schedulePlans as $schedulePlan) {
                    $schedulePlan->delete();
                }
                $resin->delete();
            }
            $machine->delete();
        }

        $line->delete();
        return redirect()->back()->with('success', 'ลบสำเร็จ');
    }

    public function reports($department_id)
    {
        $department_name = Departments::where('id', $department_id)->value('name');
        $lines = Lines::where('department_id', $department_id)->get();
        return view('lines.reports', compact('department_id', 'department_name', 'lines'));
    }
    public function line_report($department_id, $line_id, Request $request)
    {
        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);
        if ($request) {
            $since_date = $request->get('since_date');
            $to_date = $request->get('to_date');


            $resin_records = Resin_records::whereDate('created_at', '>=', $since_date)
                ->whereDate('created_at', '<=', $to_date)
                ->whereHas('machine', function ($query) use ($line_id) {
                    $query->where('line_id', $line_id);
                })->orderBy('created_at', 'ASC')->get();


            return view('reports.lines.line_report', compact(
                'department',
                'line',
                'since_date',
                'to_date',
                'resin_records'
            ));
        } else {
            return redirect()->back()->with('error', 'ไม่มี Request ');
        }
    }
}
