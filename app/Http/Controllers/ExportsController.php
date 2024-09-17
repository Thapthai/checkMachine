<?php

namespace App\Http\Controllers;

use App\Exports\AlcReportExport;
use App\Exports\DepartmentExport;
use App\Exports\Fixed_reportExport;
use App\Exports\Machines_reportExport;
use App\Exports\Parts_reportsExport;
use App\Exports\Resins_reportsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LineResinReportExport;
use App\Exports\LineResinIncompleteReportExport;
use App\Models\Departments;
use App\Models\Machines;
use App\Models\Resin_records;
use Illuminate\Http\Request;

class ExportsController extends Controller
{
    public function parts_report_export()
    {
        $time = date("d-M-Y G:i");
        return Excel::download(new Parts_reportsExport, 'Parts_report' . $time . '.xlsx');
    }
    public function resins_report_export(Request $request)
    {

        $since_date = date('Y-m-d', strtotime($request->get('start_date')));
        $to_date = date('Y-m-d', strtotime($request->get('end_date')));
        $machine_id = $request->get('machine_id');
        $department_id = $request->get('department_id');

        $department = Departments::findOrFail($department_id);

        $machine = Machines::findOrFail($machine_id);
        $resin_records = Resin_records::whereDate('created_at', '>=', $since_date)
            ->whereDate('created_at', '<=', $to_date)
            ->whereHas('machine', function ($query) use ($machine_id) {
                $query->where('id', $machine_id);
            })->orderBy('created_at', 'ASC')->get();

        $time = date("d-M-Y G:i");

        return Excel::download(new Resins_reportsExport($department, $machine, $resin_records, $since_date, $to_date), 'Resins_report' . $time . '.xlsx');
    }
    public function machines_report_excel()
    {
        $time = date("d-M-Y G:i");
        return Excel::download(new Machines_reportExport, 'machine_report' . $time . '.xlsx');
    }

    public function fixed_report_excel()
    {

        $time = date("d-M-Y G:i");
        return Excel::download(new Fixed_reportExport, 'รายงานบันทึการซ่อม_report' . $time . '.xlsx');
    }

    public function alc_report_excel(Request $request)
    {
        $department_id = $request->get('department_id');
        $department_name = $request->get('department_name');
        $since_date = $request->get('start_date');
        $to_date = $request->get('end_date');

        $time = date("d-M-Y-G-i");

        return Excel::download(
            new AlcReportExport($department_id, $since_date, $to_date),
            'รายงาน แอลกอฮอล์ และ คลอรีน ' . $department_name . '-' . 'ระหว่างวันที่' . $since_date . '|' . $to_date . $time . '.xlsx'
        );
    }

    public function lines_reports_export_xlsx(Request $request)
    {
        $line = $request->get('line_id');
        $department = $request->get('department_id');
        $since_date = $request->get('since_date');
        $to_date = $request->get('to_date');
        $time = date("d-M-Y G:i");
        return Excel::download(new LineResinReportExport($line, $department, $since_date, $to_date), 'line-resin-' . $time . '.xlsx');
    }
    public function lines_resin_incomplete_reports_export_xlsx(Request $request)
    {
        $line = $request->get('line_id');
        $department = $request->get('department_id');
        $since_date = $request->get('since_date');
        $to_date = $request->get('to_date');

        $time = date("d-M-Y G:i");

        return Excel::download(
            new LineResinIncompleteReportExport($line, $department, $since_date, $to_date),
            'line-resin-incomplete' . $time . '.xlsx'
        );
    }

    public function department_excel($department_id)
    {
        $time = date("d-M-Y G:i");
        $department = Departments::find($department_id); // ปรับ logic ให้เข้ากับการดึงข้อมูล department ที่ต้องการ
        return Excel::download(new DepartmentExport($department), 'ข้อมูล Deapartment-' . $department->name . '-' . $time . '.xlsx');
    }
}
