<?php

namespace App\Console\Commands;

use App\Models\Departments;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepartmentReportMail;
use App\Models\Lines;

class SendDepartmentReportEmail extends Command
{

    protected $signature = 'email:send-department-report {departmentId}';
    protected $description = 'Send department report email';



    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $departmentId = $this->argument('departmentId');
        $date = date('Y-m-d', strtotime('-1 days'));
        $department = Departments::find($departmentId);
        $lines = Lines::where('department_id', $department->id)->get();

        if (!$department) {
            $this->error('Department not found.');
            return;
        }


        Mail::send(new DepartmentReportMail($date, $department, $lines));

        $this->info('Report email sent successfully!');
    }
}
