<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Mail\AlcMail;
use App\Mail\ResinIncompleteMail;
use App\Mail\ResinMail;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Resin_records;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LineResinIncompleteReportExport;
use App\Exports\LineResinReportExport;
use App\Exports\AlcReportExport;


class EmailController extends Controller
{
    public function sendEmail_resin($department_id, $line_id, $since_date, $to_date, Request $request)
    {

        $department_id = $request->input('department_id');
        $line_id = $request->input('line_id');

        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);
        $resin_records = Resin_records::whereDate('created_at', '>=', $since_date)
            ->whereDate('created_at', '<=', $to_date)
            ->whereHas('machine', function ($query) use ($line_id) {
                $query->where('line_id', $line_id);
            })->orderBy('created_at', 'ASC')->get();

        $time = date("d-M-Y");
        $fileName = $line->name . 'line-resin-' . $time . '.xlsx';
        $filePath = 'public/excel/lines/' . $fileName;

        Excel::store(new LineResinReportExport($line_id, $department_id, $since_date, $to_date), $filePath);

        Mail::send(new ResinMail($line, $department, $resin_records, $since_date, $to_date, $filePath));

        return redirect()->route('reports.index', [$department_id, $line_id])->with('success', 'ส่ง Email สำเร็จ');
    }
    public function sendEmail_resin_incomplete($department_id, $line_id, $since_date, $to_date, Request $request)
    {

        $department_id = $request->input('department_id');
        $line_id = $request->input('line_id');

        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);
        $resin_records = Resin_records::whereDate('created_at', '>=', $since_date)
            ->whereDate('created_at', '<=', $to_date)
            ->where('status', 'NOT')
            ->orWhere('clean', 'NOT')
            ->whereHas('machine', function ($query) use ($line_id) {
                $query->where('line_id', $line_id);
            })->orderBy('created_at', 'ASC')->get();
        $time = date("d-M-Y");
        $fileName = $line->name . 'line-resin-incomplete-' . $time . '.xlsx';
        $filePath = 'public/excel/' . $fileName;

        Excel::store(new LineResinIncompleteReportExport($line_id, $department_id, $since_date, $to_date), $filePath);

        Mail::send(new ResinIncompleteMail($line, $department, $resin_records, $since_date, $to_date, $filePath));

        return redirect()->route('reports.index', [$department_id, $line_id])->with('success', 'ส่ง Email สำเร็จ');
    }


    public function sendEmail_alc($department_id, $since_date, $to_date)
    {
        $department = Departments::findOrFail($department_id);
        $time = date("d-M-Y");
        $fileName = $department->name . 'Alc-Report-' . $time . '.xlsx';
        $filePath = 'public/excel/alc-report/' . $fileName;

        Excel::store(new AlcReportExport($department_id, $since_date, $to_date), $filePath);
        Mail::send(new AlcMail($department, $since_date, $to_date, $filePath));

        return redirect()->route('alc_report', [$department_id])->with('success', 'ส่ง Email สำเร็จ');

    }
}
