<?php

namespace Database\Seeders;

use App\Models\ScheduleCheck\FrequencyChecks;
use Illuminate\Database\Seeder;

class CreateScheduleSeeder extends Seeder
{
    public function run()
    {
        $frequencyChecks = [
            [
                'name' => 'Daily',
            ],
            [
                'name' => 'Weekly',
            ],
            [
                'name' => 'Monthly',
            ],


        ];
        foreach ($frequencyChecks as $key => $value) {
            FrequencyChecks::create($value);
        }
    }
}
