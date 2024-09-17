<?php

namespace App\Mail;

use App\Models\Approves;
use App\Models\Departments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $approveId;
    public $department_id;


    public function __construct($approveId, $department_id)
    {
        $this->approveId = $approveId;
        $this->department_id = $department_id;
    }

    public function build()
    {
        $department = Departments::findOrFail($this->department_id);

        if ($department->name == 'PK') {
            $to_email = 'PK_Staff@Lannaagro.com';
        }

        if ($department->name == 'PF') {
            $to_email = 'PfIQF_Staff@Lannaagro.com';
        }

        if ($department->name == 'RTE') {
            $to_email = 'RTE_Staff@Lannaagro.com';
        }

        $mail_data = 'noreply@lannaagro.com';
        $cc_email = 'thapthai@lannaagro.com';
        $date = date('d/m/Y');
        $approveId = $this->approveId;
        $url = 'http://127.0.0.1:8000/approve_page/' . $approveId;
        return $this->from($mail_data, 'MT Check ')->to($to_email)
            ->cc($cc_email)
            ->view('approves.mailApprove', compact(
                'url',
                'approveId',
                'date'
            ))->subject('MT Check Approve (ทดสอบการส่ง)' . $date);
    }
}
