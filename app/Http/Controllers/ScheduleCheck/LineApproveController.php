<?php

namespace App\Http\Controllers\ScheduleCheck;

use App\Http\Controllers\Controller;
use App\Models\Resins;
use App\Models\ScheduleCheck\Approve;
use App\Models\ScheduleCheck\ScheduleRecords;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;


class LineApproveController extends Controller
{

    public function redirectToProvider($scheduleRecord_id)
    {
        // เก็บค่า scheduleRecord_id ใน session
        Session::put('scheduleRecord_id', $scheduleRecord_id);
        return Socialite::driver('line')->redirect();
    }

    public function handleProviderCallback()
    {

        $line_user = Socialite::driver('line')->user();
        Session::put('line_user', $line_user);

        $scheduleRecord_id = Session::get('scheduleRecord_id');

        return redirect()->route('approve.schedule', ['scheduleRecord_id' => $scheduleRecord_id]);
    }

    public function approveSchedule($scheduleRecord_id)
    {
        // ดึงข้อมูล scheduleRecord และ user จาก session
        $scheduleRecord = ScheduleRecords::findOrFail($scheduleRecord_id);
        $shiftDate = $scheduleRecord->shift_date;
        $resin = Resins::findOrFail($scheduleRecord->resin_id);
        $line_user = Session::get('line_user');

        $scheduleRecords = ScheduleRecords::where('shift_date', $shiftDate)
            ->where('resin_id', $resin->id)
            ->get();

        $approve_status = [
            '1' => 'ใช้งานได้ แก้ไขภายหลัง',
            '2' => 'ให้ใช้งานได้ แต่กำหนดความถี่ตรวจสอบ',
            '3' => 'ห้ามใช้งาน แจ้งช่างแก้ไขทันที',
            '4' => 'ห้ามใช้งาน ให้ Production แก้ไขทันที',
        ];
        return view('ScheduleCheck.approve.index', compact(
            'resin',
            'scheduleRecord',
            'line_user',
            'approve_status'
        ));
    }
    public function approveStore($line_user, $scheduleRecord_id, Request $request)
    {

        $approve = Approve::where('schedule_record_id', $scheduleRecord_id)->first();
        $message = 'Approve แล้ว';

        if (is_null($approve)) {
            $approve = Approve::create([
                'schedule_record_id' => $scheduleRecord_id,
                'status' => $request->approve_status,
                'detail' => $request->detail,
                'user_approve' => $line_user,
            ]);

            $lineAlert = new LineAlertController;
            $lineAlert->response_approve($approve);
            $message = 'Approve สำเร็จ';

        }


        return view('ScheduleCheck.approve.result', compact('message', 'approve'));
    }
}
