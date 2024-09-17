<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $department;
    public $line;
    public $resin_records;
    public $since_date;
    public $to_date;
    public $filePath;


    public function __construct($line, $department, $resin_records, $since_date, $to_date, $filePath)
    {
        $this->line = $line;
        $this->department = $department;
        $this->resin_records = $resin_records;
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
        $line = $this->line;
        $resin_records = $this->resin_records;
        $since_date = $this->since_date;
        $to_date = $this->to_date;


        return $this->from($mail_data, 'MT Check')->to($email)
            ->view('email.line_resin', compact(
                'department',
                'line',
                'resin_records',
                'since_date',
                'to_date'
            ))->attach(storage_path('app/' . $this->filePath))
            ->subject('ทดสอบ Resin Report วันที่ ' . $date);
    }
}
