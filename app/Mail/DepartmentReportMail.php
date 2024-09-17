<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DepartmentReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $date;

    private $department;
    private $lines;

    public function __construct($date, $department, $lines)
    {
        $this->date = $date;
        $this->department = $department;
        $this->lines = $lines;
    }


    public function build()
    {
        $department = $this->department;
        $lines = $this->lines;
        $date = $this->date;

        $to_email = 'thapthai@Lannaagro.com';

        switch ($department->name) {
            case 'PF':
                $to_email = 'PF_Sup@Lannaagro.com';
                break;
            case 'PK':
                $to_email = 'PK_Sup@Lannaagro.com';

                break;
        }

        $mail_data = 'noreply@lannaagro.com';
        $cc_email = 'thapthai@lannaagro.com';


        return $this->from($mail_data, 'MT Check Resin (ทดสอบระบบ)')
            ->to($to_email)
            ->cc($cc_email)
            ->view('email.departmentReport', compact(
                'department',
                'lines',
                'date'
            ))
            ->subject('ทดสอบ รายงานวันที่ ' . $date);
    }
}
