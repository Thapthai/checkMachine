<?php

namespace App\Mail;

use App\Models\Alc_usage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlcMail extends Mailable
{
    use Queueable, SerializesModels;
    public $department;
    public $since_date;
    public $to_date;
    public $filePath;


    public function __construct($department, $since_date, $to_date, $filePath)
    {
        $this->department = $department;
        $this->since_date = $since_date;
        $this->to_date = $to_date;
        $this->filePath = $filePath;
    }


    public function build()
    {
        $mail_data = 'noreply@lannaagro.com';
        $email = 'thapthai@lannaagro.com';
        $date = date('d/m/Y');

        $department = $this->department;
        $since_date = $this->since_date;
        $to_date = $this->to_date;

        $department_name = $department->name;

        $alc_usages = Alc_usage::whereBetween('shift_date', [$since_date . " 00:00:00", $to_date . " 00:00:00"])->get();

        return $this->from($mail_data, 'MT Check Alc')->to($email)
            ->view('email.alc', compact(
                'department_name',
                'alc_usages',
                'since_date',
                'to_date'
            ))->attach(storage_path('app/' . $this->filePath))
            ->subject('ทดสอบ รายงานแอลกอฮอล์ และ คลอรีน วันที่ ' . $date);
    }
}
