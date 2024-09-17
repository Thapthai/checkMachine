<?php

namespace Database\Seeders;

use App\Models\Departments;
use App\Models\Shifts;
use Illuminate\Database\Seeder;

class ShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Departments::all();

        foreach ($departments as $department) {

            if (strtolower($department->name) == 'pf') {
                Shifts::create([
                    'name' => 'all day',
                    'department_id' => $department->id,
                    'time_start' => '08:00',
                    'time_end' => '08:00',
                    'desc' => 'ไม่มีการตรวจแบบแยกกะ',
                    'status' => 'Active'
                ]);
            } else {

                Shifts::create([
                    'name' => 'B',
                    'department_id' => $department->id,
                    'time_start' => '08:00',
                    'time_end' => '20:00',
                    'desc' => 'กะ B',
                    'status' => 'Active'
                ]);
                Shifts::create([
                    'name' => 'C',
                    'department_id' => $department->id,
                    'time_start' => '20:00',
                    'time_end' => '08:00',
                    'desc' => 'กะ C',
                    'status' => 'Active'
                ]);
            }
        }
    }
}
