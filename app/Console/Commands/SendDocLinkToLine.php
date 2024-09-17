<?php

namespace App\Console\Commands;

use App\Models\Machines;
use App\Models\Resin_records;
use App\Models\Resins;
use App\Models\User;
use App\Notifications\SendDocLinkNotification;
use Illuminate\Console\Command;

class SendDocLinkToLine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send_doc_link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');

        if (date('D') != 'Sun') {
            // =========================== TEST Messages ===========================
            // if ($time <= '17:00:00' && $time >= '15:00:00') {

            //     $onshift = 'b';
            //     $check_in = 'after';

            //     $this->report($onshift, $check_in, $date);
            //     $this->not_check($onshift, $check_in, $date);
            // }


            // =========================== B before ===========================
            if ($time <= '12:05:00' && $time >= '12:00:00') {

                $onshift = 'b';
                $check_in = 'before';

                $this->report($onshift, $check_in, $date);
                $this->not_check($onshift, $check_in, $date);
            }

            // =========================== B after ===========================
            if ($time <= '19:35:00' && $time >= '19:30:00') {

                $onshift = 'b';
                $check_in = 'after';
                $this->report($onshift, $check_in, $date);
                $this->not_check($onshift, $check_in, $date);
            }


            // =========================== C before ===========================
            if ($time <= '23:05:00' && $time >= '23:00:00') {

                $onshift = 'c';
                $check_in = 'before';
                $this->report($onshift, $check_in, $date);
                $this->not_check($onshift, $check_in, $date);
            }

            if (date('D') != 'Mon') {
                // =========================== C after ===========================
                if ($time <= '07:05:00' && $time >= '07:00:00') {

                    $onshift = 'c';
                    $check_in = 'after';
                    $current_day = date('Y-m-d', strtotime($date . "-1 days"));
                    $this->report($onshift, $check_in, $current_day);
                    $this->not_check($onshift, $check_in, $date);
                }
            }
        }
    }
    public function report($onshift, $check_in, $date)
    {

        if ($check_in == "before") {
            $check_in_th = "ก่อนการใช้งาน";
        }
        if ($check_in == "after") {
            $check_in_th = "หลังการใช้งาน";
        }



        $machines = Machines::get();
        $machine_reports = [];
        $report = [];

        foreach ($machines as $machine) {
            if (count($machine->resins) > 0) {
                foreach ($machine->resins as $resin) {
                    foreach ($resin->resin_records as $resin_record) {
                        if (
                            $resin_record->status == 'NOT'
                            && $resin_record->created_at->format('Y-m-d') ==  $date
                            && $resin_record->on_shift == $onshift
                            && $resin_record->check_in == $check_in
                        ) {
                            $machine_reports[$machine->id] = $machine;
                            $report[$machine->id][] = $resin_record;
                        }
                    }
                }
            }
        }

        if (count($report) > 0) {

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            date_default_timezone_set("Asia/Bangkok");

            $sToken = "4JFc1anaTbUXDfH0UMyzNxnkWli2ud6MrB0IP7hPb5W";

            $sMessage = "จุดที่พกพร่อง" . "\n";
            $sMessage .= "  " . "กะ : " . $onshift . " " . $check_in_th . "\n";

            foreach ($machine_reports as $key => $machine_report) {
                $sMessage .= "- แผนก : " . $machine_report->department->name . "| ไลน์ : " . $machine_report->line->name . "| เครื่องจักร : " . $machine_report->name . "\n";
                foreach ($report[$key] as $resin_record) {
                    $sMessage .= "    " . $resin_record->resin->sequence . "." . $resin_record->resin->position . ": " . "ความสมบูรณ์ " . ": " . $resin_record->status . " " . "| " . "ความสะอาด " . ": " . $resin_record->clean . "\n";
                }
            }
            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);

            //Result error
            if (curl_error($chOne)) {
                echo 'error:' . curl_error($chOne);
            } else {
                $result_ = json_decode($result, true);
                echo "status : " . $result_['status'];
                echo "message : " . $result_['message'];
            }
            curl_close($chOne);
        }
    }

    public function not_check($onshift, $check_in, $date)
    {
        if ($check_in == "before") {
            $check_in_th = "ก่อนการใช้งาน";
        }
        if ($check_in == "after") {
            $check_in_th = "หลังการใช้งาน";
        }

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        $sToken = "4JFc1anaTbUXDfH0UMyzNxnkWli2ud6MrB0IP7hPb5W";

        $sMessage = "จุดที่ค้างตรวจ \n";
        $sMessage .= "  " . "กะ : " . $onshift . " " . $check_in_th . "\n";

        $machines = Machines::get();

        foreach ($machines as $machine) {
            $count_resin_records_before = [];

            foreach ($machine->resin_records as $resin_record) {
                if (
                    $resin_record->check_in == $check_in &&
                    $resin_record->created_at->format('Y-m-d') == $date &&
                    $resin_record->on_shift == $onshift
                ) {
                    $checked_before = $resin_record;
                    $count_resin_records_before[] = $resin_record->id;
                }
            }
            if ($machine->resins->count() != count($count_resin_records_before)) {

                $sMessage .= $machine->department->name . "|" . $machine->line->name . "|" . $machine->name . "\n";
            } else {
            }
        }

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];
        }
        curl_close($chOne);
    }
}
