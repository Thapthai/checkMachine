<?php

namespace App\Http\Controllers\ScheduleCheck;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use App\Models\Resins;
use App\Models\ScheduleCheck\FrequencyChecks;
use App\Models\ScheduleCheck\SchedulePlans;
use App\Models\ScheduleCheck\ScheduleRecords;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleCheckController extends Controller
{
    public function index($line_id)
    {
        $line = Lines::findOrFail($line_id);
        $machines = Machines::where('line_id', $line_id)->get();
        $frequencyChecks = FrequencyChecks::all();

        return view('ScheduleCheck.schedulePlan.index', compact(
            'line',
            'machines',
            'frequencyChecks'
        ));
    }

    public function machines_schedule_plan($department_id, $onshift, $selected, $line_id, $machine_id, $shiftDate)
    {

        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);

        $machine = Machines::findOrFail($machine_id);

        $frequencyChecks = FrequencyChecks::all();
        return view('ScheduleCheck.schedulePlanMachine.index', compact(
            'department',
            'line',
            'onshift',
            'selected',
            'machine',
            'shiftDate',
            'frequencyChecks'
        ));
    }

    public function schedule_plan($department_id, $onshift, $selected, $line_id, $machine_id, Request $request)
    {
        $machine = Machines::findOrFail($machine_id);
        $scheduleReins = $request->scheduleResins;

        // Get existing schedule plans for the machine
        $existingSchedulePlans = SchedulePlans::where('machine_id', $machine->id)->get();
        $existingSchedulePlansMap = $existingSchedulePlans->keyBy(function ($item) {
            return $item->frequency_check_id . '-' . $item->resin_id;
        });

        // Collect new schedule plans keys
        $newSchedulePlansMap = [];

        foreach ($scheduleReins as $frequencyCheck_id => $resins) {
            foreach ($resins as $resin_id => $value) {

                $key = $frequencyCheck_id . '-' . $resin_id;

                $newSchedulePlansMap[$key] = [
                    'line_id' => $machine->line->id,
                    'machine_id' => $machine->id,
                    'frequency_check_id' => $frequencyCheck_id,
                    'resin_id' => $resin_id,
                    'define' => $value
                ];

                // If it exists, update it, otherwise create a new one
                if (isset($existingSchedulePlansMap[$key])) {
                    $existingSchedulePlansMap[$key]->update(['define' => $value]);
                    unset($existingSchedulePlansMap[$key]);
                } else {
                    SchedulePlans::create($newSchedulePlansMap[$key]);
                }
            }
        }

        // Delete remaining old schedule plans
        foreach ($existingSchedulePlansMap as $schedulePlan) {
            $schedulePlan->delete();
        }

        return redirect()->back()->with('success', 'บันทึกสำเร็จ');
    }

    public function select_schedule_plan($department_id, $onshift, $selected, $line_id, $machine_id, $shiftDate)
    {
        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);
        $machine = Machines::findOrFail($machine_id);
        $frequencyChecks = FrequencyChecks::all();

        return view('ScheduleCheck.schedulePlanMachine.selectSchedule', compact(
            'department',
            'onshift',
            'selected',
            'line',
            'machine',
            'shiftDate',
            'frequencyChecks',
        ));
    }

    public function schedule_plan_check($department_id, $onshift, $selected, $line_id, $machine_id, $shiftDate, $frequencyCheck_id)
    {

        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);
        $machine = Machines::findOrFail($machine_id);
        $frequencyCheck = FrequencyChecks::findOrFail($frequencyCheck_id);


        $schedulePlans = SchedulePlans::with('resin.machine')
            ->where('frequency_check_id', $frequencyCheck_id)
            ->where('line_id', $line_id)
            ->get()
            ->filter(function ($schedulePlan) use ($machine_id) {
                return $schedulePlan->resin && $schedulePlan->resin->machine && $schedulePlan->resin->machine->id == $machine_id;
            });


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

        return view('ScheduleCheck.checkResin.index', compact(
            'department',
            'onshift',
            'selected',
            'line',
            'machine',
            'shiftDate',
            'frequencyCheck',
            'schedulePlans',
            'inspectionStartDate',
            'inspectionEndDate'
        ));
    }

    public function schedule_record($department_id, $onshift, $selected, $line_id, $machine_id, $shiftDate, $resin_id, $schedulePlan_id, Request $request)
    {

        $schedulePlan = SchedulePlans::findOrFail($schedulePlan_id);


        if ($schedulePlan->frequency_check->name == 'Monthly') {
            $this->storeData($onshift, $schedulePlan, $resin_id, $request);

            $schedulePlanWeekly = SchedulePlans::where('resin_id', $resin_id)
                ->whereHas('frequency_check', function ($query) {
                    $query->where('name', 'Weekly');
                })->get();

            if ($schedulePlanWeekly) {
                foreach ($schedulePlanWeekly as $plan) {
                    $this->storeData($onshift, $plan, $resin_id, $request);
                }
            }

            $schedulePlanDaily = SchedulePlans::where('resin_id', $resin_id)
                ->whereHas('frequency_check', function ($query) {
                    $query->where('name', 'Daily');
                })->get();

            if ($schedulePlanDaily) {
                foreach ($schedulePlanDaily as $plan) {
                    $this->storeData($onshift, $plan, $resin_id, $request);
                }
            }
        }

        if ($schedulePlan->frequency_check->name == 'Weekly') {
            $this->storeData($onshift, $schedulePlan, $resin_id, $request);

            $schedulePlanDaily = SchedulePlans::where('resin_id', $resin_id)
                ->whereHas('frequency_check', function ($query) {
                    $query->where('name', 'Daily');
                })->get();


            if ($schedulePlanDaily) {
                foreach ($schedulePlanDaily as $plan) {
                    $this->storeData($onshift, $plan, $resin_id, $request);
                }
            }
        }

        if ($schedulePlan->frequency_check->name == 'Daily') {
            $this->storeData($onshift, $schedulePlan, $resin_id, $request);
        }


        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);
        $machine = Machines::findOrFail($machine_id);
        $resin = Resins::findOrFail($resin_id);

        if ($request->clean == 'NOT' || $request->complete == 'NOT') {
            $lineAlert = new LineAlertController;
            $lineAlert->lineAlert($department, $line, $machine, $resin, $shiftDate, $schedulePlan, $request);
            $lineAlert->lineAlert_all($department, $line, $machine, $resin, $request);
        }


        return redirect()->back()->with('success', 'บันทึกสำเร็จ');
    }

    public function storeData($onshift, $schedulePlan, $resin_id, $request)
    {
        $shiftDate = $request->get('shiftDate');
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
            'shift_date' => date('Y-m-d', strtotime($shiftDate)),
            'on_shift' => $onshift,
            'check_in' => 'checkType',
            'status' => 'checked',
            'pic1' => $path[0],
            'pic2' => $path[1],
            'pic3' => $path[2],
        ]);

        return $scheduleRecord;
    }
}
