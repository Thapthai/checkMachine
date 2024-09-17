<?php

namespace App\Http\Controllers\Admin\Mange;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use App\Models\ScheduleCheck\FrequencyChecks;
use App\Models\ScheduleCheck\SchedulePlans;
use Illuminate\Http\Request;

class SchedulePlanController extends Controller
{
    public function machine(Departments $department, Lines $line, Request $request)
    {

        $frequenctChecks = FrequencyChecks::all();

        return view('admin.department.manage.resinApp.schedulePlan.machine.index', compact(
            'department',
            'line',
            'frequenctChecks'
        ));
    }

    public function schedule_plan($department_id, $line_id, $machine_id, Request $request)
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

        if (!empty($scheduleReins)) {

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
        }

        // Delete remaining old schedule plans
        foreach ($existingSchedulePlansMap as $schedulePlan) {
            $schedulePlan->delete();
        }

        return redirect()->back()->with('success', 'บันทึกสำเร็จ');
    }
}
