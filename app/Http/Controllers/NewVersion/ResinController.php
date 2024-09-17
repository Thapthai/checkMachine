<?php

namespace App\Http\Controllers\NewVersion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ScheduleCheck\LineAlertController;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use App\Models\Resins;
use App\Models\ScheduleCheck\FrequencyChecks;
use App\Models\ScheduleCheck\SchedulePlans;
use App\Models\ScheduleCheck\ScheduleRecords;
use App\Models\Shifts;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class ResinController extends Controller
{
    public function timeShift($department_id)
    {
        $department = Departments::findOrFail($department_id);
        $data = [];
        $time = date('H:i');
        $data['date'] = date('Y-m-d');


        $shifts = Shifts::where('department_id', $department->id)->get();

        if ($time >= '00:00' && $time < "08:00") {
            $timeDiff = 'DIFF';
            $data['date'] = date('Y-m-d', strtotime('-1 day'));
        } else {
            $timeDiff = 'SAME';
        }

        $timeShift = '';
        foreach ($shifts as $key => $shift) {

            if (strtolower($shift->desc) == 'all') {
                $data['shift'] = $shift->name;
            } else {
                if ($shift->desc == $timeDiff) {
                    $data['shift'] = $shift->name;
                }
            }
        }


        return $data;
    }

    public function appName($app)
    {
        switch ($app) {
            case 'resin':
                $appName = 'ตรวจสอบ เรซิ่น';

                break;
            case 'part':
                $appName = 'ตรวจสอบ ชิ่นส่วน';

                break;

            case 'alc':
                $appName = 'แอลกอฮอล์ และ คลอรีน';

                break;


            default:

                break;
        }
        return $appName;
    }

    private function getInspectionMonthRange()
    {
        $year = date('Y');
        $month = date('m');

        // หาวันที่สิ้นเดือน
        $lastDayOfMonth = date("Y-m-t", strtotime("$year-$month-01"));

        // หาวันที่เริ่มต้นของสัปดาห์สุดท้าย
        $firstDayOfLastWeekOfMonth = date("Y-m-d", strtotime("last sunday", strtotime($lastDayOfMonth)));

        // หาวันที่สิ้นสุดของสัปดาห์สุดท้าย
        $lastWeekOfMonth = date("Y-m-d", strtotime("next saturday", strtotime($firstDayOfLastWeekOfMonth)));

        // หาวันที่เริ่มต้นของเดือนถัดไป
        $nextMonthFirstDay = date("Y-m-d", strtotime("+1 month", strtotime("$year-$month-01")));

        // หาวันที่เริ่มต้นของสัปดาห์แรกของเดือนถัดไป
        // $firstDayOfNextWeek = date("Y-m-d", strtotime("last sunday", strtotime($nextMonthFirstDay)));
        $firstDayOfNextWeek = date("Y-m-d",  strtotime($nextMonthFirstDay));

        // หาวันที่สิ้นสุดของสัปดาห์แรกของเดือนถัดไป
        $lastDayOfFirstWeekOfNextMonth = date("Y-m-d", strtotime("next saturday", strtotime($firstDayOfNextWeek)));

        $inspectionStartDate = $firstDayOfLastWeekOfMonth;
        $inspectionEndDate = $lastDayOfFirstWeekOfNextMonth;

        return [
            'inspectionStartDate' => $inspectionStartDate,
            'inspectionEndDate' => $inspectionEndDate
        ];
    }

    private function getInspectionWeekRange($shiftDate)
    {

        $week = date('W', strtotime($shiftDate));
        $year = date('Y', strtotime($shiftDate));

        // วันที่เริ่มต้นของสัปดาห์ (วันจันทร์)
        $startOfWeek = new DateTime();
        $startOfWeek->setISODate($year, $week, 1); // 1 = วันจันทร์
        $startOfWeekFormatted = $startOfWeek->format('Y-m-d');

        // วันที่สิ้นสุดของสัปดาห์ (วันอาทิตย์)
        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('+6 days');
        $endOfWeekFormatted = $endOfWeek->format('Y-m-d');



        return ['inspectionStartDate' => $startOfWeekFormatted, 'inspectionEndDate' => $endOfWeekFormatted];
    }

    public function index(Departments $department, $app)
    {
        $frequencyChecks = FrequencyChecks::all();
        $appName = $this->appName($app);

        return view('NewVersion.app.resin.index', compact('department', 'app', 'appName', 'frequencyChecks'));
    }


    public function line_select(Departments $department, $app, $frequencyCheck_id)
    {

        $frequencyCheck = FrequencyChecks::findOrFail($frequencyCheck_id);

        $lines = Lines::where('department_id', $department->id)->where('status', 'Active')->get();
        $shift = $this->timeShift($department->id);
        $appName = $this->appName($app);
        $scheduleDefine = null;

        if ($frequencyCheck->name == 'Weekly') {
            $scheduleDefine = $this->getInspectionWeekRange($shift['date']);
        }

        if ($frequencyCheck->name == 'Monthly') {
            $scheduleDefine = $this->getInspectionMonthRange();
        }

        return view('NewVersion.app.resin.schedeule.line_select', compact(
            'department',
            'app',
            'lines',
            'frequencyCheck',
            'shift',
            'appName',
            'scheduleDefine'
        ));
    }

    public function machine(Departments $department, $app, $frequencyCheck_id, Lines $line, Request $request)
    {

        $frequencyCheck = FrequencyChecks::findOrFail($frequencyCheck_id);

        $shift = $this->timeShift($department->id);
        $appName = $this->appName($app);
        $searchMachine = '';

        $searchMachine = $request->input('searchMachine', '');

        return view('NewVersion.app.resin.schedeule.machine', compact(
            'department',
            'app',
            'line',
            'frequencyCheck',
            'shift',
            'appName',
            'searchMachine'

        ));
    }
    public function resin(Departments $department, $app, $frequencyCheck_id, Lines $line, $machine_id, Request $request)
    {
        $frequencyCheck = FrequencyChecks::findOrFail($frequencyCheck_id);
        $machine = Machines::findOrFail($machine_id);

        $shift = $this->timeShift($department->id);
        $appName = $this->appName($app);
        $searchResin = $request->input('searchResin', '');


        return view('NewVersion.app.resin.schedeule.resin', compact(
            'department',
            'app',
            'line',
            'frequencyCheck',
            'machine',
            'shift',
            'appName',
            'searchResin'
        ));
    }
    public function storeData($shift, $schedulePlan, $resin_id, $request)
    {

        $storage_path = storage_path('app/public/upload_schedule_record/');
        $path = [];
        $pic = ['pic1', 'pic2', 'pic3'];

        foreach ($pic as $key => $value) {
            if ($request->hasFile($value)) {
                if (!is_dir($storage_path)) {
                    mkdir($storage_path, 0777, true);
                }

                $name = time() . $value . '.' . $request->file($value)->getClientOriginalExtension();
                $path[$key] = 'upload_schedule_record/' . $name;

                $image = Image::make($request->file($value));

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

                $image->save($storage_path . $name);
            } else {
                $path[$key] = null;
            }
        }

        $scheduleRecord = ScheduleRecords::create([
            'schedule_plan_id' => $schedulePlan->id,
            'resin_id' => $resin_id,
            'complete' => $request->complete,
            'clean' => $request->clean,
            'detail' => $request->detail,
            'by_user' => Auth::user()->id,
            'shift_date' => date('Y-m-d', strtotime($shift['date'])),
            'on_shift' => $shift['shift'],
            'check_in' => 'checkType',
            'status' => 'checked',
            'pic1' => $path[0],
            'pic2' => $path[1],
            'pic3' => $path[2],
        ]);

        return $scheduleRecord;
    }


    public function scheduleRecord(Departments $department, $app, $frequencyCheck_id, $schedulePlan_id, $resin_id, Request $request)
    {

        $shift = $this->timeShift($department->id);

        $schedulePlan = SchedulePlans::findOrFail($schedulePlan_id);

        if ($schedulePlan->frequency_check->name == 'Monthly') {
            $scheduleRecord =  $this->storeData($shift, $schedulePlan, $resin_id, $request);

            $schedulePlanWeekly = SchedulePlans::where('resin_id', $resin_id)
                ->whereHas('frequency_check', function ($query) {
                    $query->where('name', 'Weekly');
                })->get();

            if ($schedulePlanWeekly) {
                foreach ($schedulePlanWeekly as $plan) {

                    $scheduleRecordCheck  = $plan->ScheduleRecords
                        ->where('shift_date', $shift['date'])
                        ->where('on_shift', $shift['shift']);

                    if ($scheduleRecordCheck->count() < 1) {
                        $scheduleRecord = $this->storeData($shift, $plan, $resin_id, $request);
                    }
                }
            }

            $schedulePlanDaily = SchedulePlans::where('resin_id', $resin_id)
                ->whereHas('frequency_check', function ($query) {
                    $query->where('name', 'Daily');
                })->get();

            if ($schedulePlanDaily) {
                foreach ($schedulePlanDaily as $plan) {

                    $scheduleRecordCheck  = $plan->ScheduleRecords
                        ->where('shift_date', $shift['date'])
                        ->where('on_shift', $shift['shift']);

                    if ($scheduleRecordCheck->count() < 1) {
                        $scheduleRecord = $this->storeData($shift, $plan, $resin_id, $request);
                    }
                }
            }
        }

        if ($schedulePlan->frequency_check->name == 'Weekly') {
            $scheduleRecord = $this->storeData($shift, $schedulePlan, $resin_id, $request);

            $schedulePlanDaily = SchedulePlans::where('resin_id', $resin_id)
                ->whereHas('frequency_check', function ($query) {
                    $query->where('name', 'Daily');
                })->get();


            if ($schedulePlanDaily) {
                foreach ($schedulePlanDaily as $plan) {

                    $scheduleRecordCheck  = $plan->ScheduleRecords
                        ->where('shift_date', $shift['date'])
                        ->where('on_shift', $shift['shift']);

                    if ($scheduleRecordCheck->count() < 1) {
                        $scheduleRecord =  $this->storeData($shift, $plan, $resin_id, $request);
                    }
                }
            }
        }

        if ($schedulePlan->frequency_check->name == 'Daily') {
            $scheduleRecord = $this->storeData($shift, $schedulePlan, $resin_id, $request);
        }

        $resin = Resins::findOrFail($resin_id);

        $machine = $resin->machine;
        $line = $machine->line;

        if ($request->clean == 'NOT' || $request->complete == 'NOT') {

            $lineAlert = new LineAlertController;
            $shiftDate = date('Y-m-d', strtotime($shift['date']));

            $lineAlert->lineAlert($department, $line, $machine, $resin, $shiftDate, $scheduleRecord, $request);
            $lineAlert->lineAlert_all($department, $line, $machine, $resin, $request);
        }

        return redirect()->back()->with('success', 'บันทึกสำเร็จ');
    }

    public function toggleLineUsage(Departments $department, $app, $frequencyCheck_id, Lines $line,  Request $request)
    {
        $shift = $this->timeShift($department->id);

        $schedulePlans = SchedulePlans::where('line_id', $line->id)
            ->where('frequency_check_id', $frequencyCheck_id)
            ->get();

        $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
            return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($shift) {
                return $scheduleRecord->shift_date == $shift['date'] &&
                    $scheduleRecord->on_shift == $shift['shift'] &&
                    $scheduleRecord->detail != 'notuse';
            });
        });

        $schedulePlansRecordIds = $schedulePlansRecord->pluck('id');
        $schedulePlansFiltereds = $schedulePlans->filter(function ($schedulePlan) use ($schedulePlansRecordIds) {
            return !$schedulePlansRecordIds->contains($schedulePlan->id);
        });

        foreach ($schedulePlansFiltereds as $schedulePlansFiltered) {

            ScheduleRecords::create([
                'schedule_plan_id' => $schedulePlansFiltered->id,
                'resin_id' => $schedulePlansFiltered->resin_id,
                'complete' => 'notuse',
                'clean' => 'notuse',
                'by_user' => Auth::user()->id,
                'check_in' => 'checkType',
                'shift_date' => date('Y-m-d', strtotime($shift['date'])),
                'on_shift' => $shift['shift'],
                'detail' => 'notuse',
                'status' => 'notuse',

            ]);
        }

        return redirect()->back()->with('success', 'ปิดการใช้งานสำเร็จ');
    }

    public function toggleMachineUsage(Departments $department, $app, $frequencyCheck_id, Lines $line, Machines $machine, Request $request)
    {

        $shift = $this->timeShift($department->id);

        $schedulePlans = SchedulePlans::where('line_id', $line->id)
            ->where('frequency_check_id', $frequencyCheck_id)
            ->where('machine_id', $machine->id)
            ->get();

        $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
            return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($shift) {
                return $scheduleRecord->shift_date == $shift['date'] &&
                    $scheduleRecord->on_shift == $shift['shift'] &&
                    $scheduleRecord->detail != 'notuse';
            });
        });

        $schedulePlansRecordIds = $schedulePlansRecord->pluck('id');
        $schedulePlansFiltereds = $schedulePlans->filter(function ($schedulePlan) use ($schedulePlansRecordIds) {
            return !$schedulePlansRecordIds->contains($schedulePlan->id);
        });

        foreach ($schedulePlansFiltereds as $schedulePlansFiltered) {

            ScheduleRecords::create([
                'schedule_plan_id' => $schedulePlansFiltered->id,
                'resin_id' => $schedulePlansFiltered->resin_id,
                'complete' => 'notuse',
                'clean' => 'notuse',
                'by_user' => Auth::user()->id,

                'check_in' => 'checkType',
                'shift_date' => date('Y-m-d', strtotime($shift['date'])),
                'on_shift' => $shift['shift'],
                'detail' => 'notuse',
                'status' => 'notuse',

            ]);
        }
        return redirect()->back()->with('success', 'ปิดการใช้งานสำเร็จ');
    }
}
