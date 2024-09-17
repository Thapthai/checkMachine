<?php

namespace App\Http\Controllers\Reports;

use App\Exports\DepartmentReport\DepartmentReportExportExcel;
use App\Http\Controllers\Controller;
use App\Mail\DepartmentReportMail;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{

    public function index(Departments $department, Request $request)
    {
        $typeDoc = null;
        $machines = null;
        $lines = null;

        if ($request) {
            $typeDoc = $request->typeDoc;
            $machines = Machines::where('department_id', $department->id)->pluck('name', 'id');
            $lines = Lines::where('department_id', $department->id)->pluck('name', 'id');
        }
        return view('admin.department.reports.index', compact('department', 'typeDoc', 'lines', 'machines'));
    }
    public function view(Departments $department, $typeDoc, Request $request)
    {

        if ($request) {

            $startDate = $request->startDate;
            $endDate = $request->endDate;

            $dates = [];
            $currentDate = strtotime($startDate);


            while ($currentDate <= strtotime($endDate)) {
                $dates[] = date('Y-m-d', $currentDate);
                $currentDate = strtotime('+1 day', $currentDate);
            }


            switch ($typeDoc) {
                case 'departmentDocType':

                    $resins = $department->lines()
                        ->with('machines.resins')
                        ->get()
                        ->pluck('machines.*.resins')
                        ->flatten();
                    $resinIds = $resins->pluck('id');




                    $lines = Lines::where('department_id', $department->id)->paginate(1);

                    return view('admin.department.reports.departmentReport.index', compact(
                        'department',
                        'typeDoc',
                        'startDate',
                        'endDate',
                        'lines',
                        'dates'
                    ));

                    break;

                case 'lineDocType':
                    // echo $typeDoc;
                    break;

                case 'machineDocType':
                    // echo $typeDoc;
                    break;

                default:
                    // คุณสามารถเพิ่มกรณี default ได้หากต้องการจัดการสถานการณ์ที่ไม่ตรงกับ case ใด ๆ
                    // echo "No matching document type.";
                    break;
            }
        }
    }

    public function exportExcel(Departments $department, $startDate, $endDate)
    {
        return Excel::download(new DepartmentReportExportExcel($department, $startDate, $endDate), 'รายงานการตรวจสอบ' . $department->name . '.xlsx');
    }

    public function sendReportEmail(Departments $department, $date)
    {

        $lines = Lines::where('department_id', $department->id)->get();

        Mail::send(new DepartmentReportMail($date, $department, $lines));

        return redirect()->back()->with('success', 'ส่ง E-Mail สำเร็จ ');



        // $dates = [];
        // $currentDate = strtotime($startDate);


        // while ($currentDate <= strtotime($endDate)) {
        //     $dates[] = date('Y-m-d', $currentDate);
        //     $currentDate = strtotime('+1 day', $currentDate);
        // }
        // return view('email.departmentReport', compact(
        //     'department',
        //     'lines',
        //     'startDate',
        //     'endDate',
        //     'dates'
        // ));
    }
}
