<?php

namespace App\Http\Controllers;

use App\Exports\Test_ExportExcelImg;
use App\Models\Departments;
use App\Models\ScheduleCheck\LineUsers;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{

    public function index()
    {

        $user = Auth::user();
        return view('tests.index', compact('user'));
    }


    public function exportExcelImg()
    {

        $department = Departments::find(1); // ปรับ logic ให้เข้ากับการดึงข้อมูล department ที่ต้องการ
        return Excel::download(new Test_ExportExcelImg($department), 'machines.xlsx');
    }
}
