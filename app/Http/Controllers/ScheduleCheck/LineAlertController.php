<?php

namespace App\Http\Controllers\ScheduleCheck;

use App\Http\Controllers\Controller;
use App\Models\Resins;
use App\Models\ScheduleCheck\ScheduleRecords;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class LineAlertController extends Controller
{

    private $lineToken_all;

    private $lineToken;

    public function __construct()
    {
        $this->lineToken = env('LINE_NOTIFY_TOKEN');
        $this->lineToken_all = env('LINE_NOTIFY_ALL_TOKEN');
    }

    private function sendLineNotifyMessage($message, $token)
    {

        $headers = [
            'Authorization: Bearer ' . $token,
        ];
        $data = [
            'message' => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        // ตรวจสอบการส่งข้อความ
        if ($result === false) {
            // error handling
        } else {
            $response = json_decode($result, true);
            if ($response['status'] !== 200) {
                // error handling
            }
        }
    }

    private function sendLineNotifyImage($file, $message, $token)
    {
        if ($file) {

            $message = $message . "\n";
            $headers = [
                'Authorization: Bearer ' . $token,
            ];

            $data = [
                'message' => $message,
            ];

            $storage_path = storage_path('app/public/tmp_line_alert/');
            if (!is_dir($storage_path)) {
                mkdir($storage_path, 0777, true);
            }

            $name = time() . '.' . $file->getClientOriginalExtension();
            $tempPath = $storage_path . $name;

            // ลดขนาดรูปภาพและตรวจสอบ EXIF Orientation
            $image = Image::make($file->getPathname());

            $orientation = $image->exif('Orientation');
            if ($orientation) {
                switch ($orientation) {
                    case 3:
                        $image->rotate(180);
                        break;
                    case 6:
                        $image->rotate(-90);
                        break;
                    case 8:
                        $image->rotate(90);
                        break;
                }
            }

            $image->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            // บันทึกรูปภาพที่ลดขนาดลงแล้ว
            $image->save($tempPath);

            $data['imageFile'] = curl_file_create($tempPath, $file->getMimeType(), $file->getClientOriginalName());

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            curl_close($ch);

            // ลบไฟล์ชั่วคราว
            unlink($tempPath);

            // ตรวจสอบการส่งข้อความ
            if ($result === false) {
                // error handling
            } else {
                $response = json_decode($result, true);
                if ($response['status'] !== 200) {
                    // error handling
                }
            }
        }
    }

    public function lineAlert($department, $line, $machine, $resin, $shiftDate, $scheduleRecord, $request)
    {

        $url = env('APP_URL');

        $message = "แจ้งเตือน: การตรวจสอบไม่สมบูรณ์\n"
            . "รายละเอียด: " . $request->detail . "\n";

        $message .= "แผนก:." . $department->name . "\n";
        $message .= "ไลน์การผลิต:." . $line->name . "\n";

        $message .= "เครื่องจักร:." . $machine->name . "\n";
        $message .= "ตำแหน่ง เรซิ่น:." . $resin->position . "\n";


        if ($request->clean == 'NOT') {
            $message .= "สถานะการทำความสะอาด: ไม่ผ่าน\n";
        }

        if ($request->complete == 'NOT') {
            $message .= "สถานะการทำงาน: ไม่ผ่าน\n";
        }

        // $scheduleRecord = ScheduleRecords::where('schedule_plan_id', $schedulePlan->id)
        //     ->where('shift_date', $shiftDate)
        //     ->where('resin_id', $resin->id)
        //     ->first();

        if ($scheduleRecord) {
            $link = $url . "approve/line/scheduleRecord/" . $scheduleRecord->id;
            $message .= "สามารถ Approve ผ่าน \n" . $link . "\n";
        }

        $token = $this->lineToken;
        $this->sendLineNotifyMessage($message, $token);


        if ($request->hasFile('pic1')) {
            $this->sendLineNotifyImage($request->file('pic1'), 'รูปภาพที่ 1', $token);
        }
        if ($request->hasFile('pic2')) {
            $this->sendLineNotifyImage($request->file('pic2'), 'รูปภาพที่ 2', $token);
        }
        if ($request->hasFile('pic3')) {
            $this->sendLineNotifyImage($request->file('pic3'), 'รูปภาพที่ 3', $token);
        }
    }

    public function lineAlert_all($department, $line, $machine, $resin, $request)
    {
        $message = "แจ้งเตือน: การตรวจสอบไม่สมบูรณ์\n"
            . "รายละเอียด: " . $request->detail . "\n";

        $message .= "แผนก:." . $department->name . "\n";
        $message .= "ไลน์การผลิต:." . $line->name . "\n";

        $message .= "เครื่องจักร:." . $machine->name . "\n";
        $message .= "ตำแหน่ง เรซิ่น:." . $resin->position . "\n";


        if ($request->clean == 'NOT') {
            $message .= "สถานะการทำความสะอาด: ไม่ผ่าน\n";
        }

        if ($request->complete == 'NOT') {
            $message .= "สถานะการทำงาน: ไม่ผ่าน\n";
        }

        $token = $this->lineToken_all;
        $this->sendLineNotifyMessage($message, $token);


        if ($request->hasFile('pic1')) {
            $this->sendLineNotifyImage($request->file('pic1'), 'รูปภาพที่ 1', $token);
        }
        if ($request->hasFile('pic2')) {
            $this->sendLineNotifyImage($request->file('pic2'), 'รูปภาพที่ 2', $token);
        }
        if ($request->hasFile('pic3')) {
            $this->sendLineNotifyImage($request->file('pic3'), 'รูปภาพที่ 3', $token);
        }
    }


    public function response_approve($approve)
    {

        $resin = Resins::findOrFail($approve->ScheduleRecord->schedule_plan->resin->id);
        $message = "แจ้งเตือน: \n";
        $message .= "แผนก:." . $resin->machine->department->name . "\n";
        $message .= "ไลน์การผลิต:." . $resin->machine->line->name . "\n";
        $message .= "เครื่องจักร:." . $resin->machine->name . "\n";
        $message .= "ตำแหน่ง เรซิ่น:." . $resin->position . "\n";
        $message .= "ผลการ Approve: " . $approve->status . "\n";
        $message .= "รายละเอียด: " . $approve->detail . "\n";
        $message .=  "\n";
        $message .= "โดย" . $approve->user_approve . "\n";

        $token = $this->lineToken;
        $token_all = $this->lineToken_all;

        $this->sendLineNotifyMessage($message, $token);
        $this->sendLineNotifyMessage($message, $token_all);
    }
}
