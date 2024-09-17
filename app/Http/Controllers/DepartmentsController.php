<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Auth;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index()
    {
    }

    public function show(Departments $department)
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'status' => 'required|in:Active,Inactive'
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        Departments::create($validatedData);

        return redirect()->back()->with('success', 'สร้างสำเร็จ.');
    }

    public function edit(Departments $department)
    {
    }

    public function update(Request $request, Departments $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        $department->fill($validatedData)->save();

        return redirect()->back()->with('success', 'แก้ไขสำเร็จ.');
    }

    public function destroy(Departments $department)
    {
        $department->delete();
        return redirect()->back()->with('success', 'ลบ สำเร็จ');
    }
}
