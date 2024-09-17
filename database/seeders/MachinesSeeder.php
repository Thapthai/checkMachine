<?php

namespace Database\Seeders;

use App\Models\Machines;
use Illuminate\Database\Seeder;

class MachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $machines = [
            // PF => Line3
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Feeding Conveyor 1',
                'detail' => 'Feeding Conveyor 1',
                'status' => 'Active',
                'sequence' => '1',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Feeding Conveyor 2',
                'detail' => 'Feeding Conveyor 2',
                'status' => 'Active',
                'sequence' => '2',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Blower Conveyor 3 ',
                'detail' => 'Blower Conveyor 3 ',
                'status' => 'Active',
                'sequence' => '3',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Blower Shaker 3 ',
                'detail' => 'Blower Shaker 3 ',
                'status' => 'Active',
                'sequence' => '4',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Blower3',
                'detail' => 'Blower3',
                'status' => 'Active',
                'sequence' => '5',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Shaker Conveyor 3 ',
                'detail' => 'Shaker Conveyor 3 ',
                'status' => 'Active',
                'sequence' => '6',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Shaker3',
                'detail' => 'Shaker3',
                'status' => 'Active',
                'sequence' => '7',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Drum grader 1',
                'detail' => 'Drum grader 1',
                'status' => 'Active',
                'sequence' => '8',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Drum grader 2',
                'detail' => 'Drum grader 2',
                'status' => 'Active',
                'sequence' => '9',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => ' Drum grader Export Conveyor ',
                'detail' => ' Drum grader Export Conveyor ',
                'status' => 'Active',
                'sequence' => '10',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Drum washer Conveyor',
                'detail' => 'Drum washer Conveyor',
                'status' => 'Active',
                'sequence' => '11',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => ' Bush Bean Sepal Cutting',
                'detail' => ' Bush Bean Sepal Cutting',
                'status' => 'Active',
                'sequence' => '12',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => ' Bush Bean Sepal Cutting',
                'detail' => ' Bush Bean Sepal Cutting',
                'status' => 'Active',
                'sequence' => '13',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Drum washer Export Conveyor ',
                'detail' => 'Drum washer Export Conveyor ',
                'status' => 'Active',
                'sequence' => '14',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Drum Washer',
                'detail' => 'Drum Washer',
                'status' => 'Active',
                'sequence' => '15',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Wash Pond Conveyor ',
                'detail' => 'Wash Pond Conveyor ',
                'status' => 'Active',
                'sequence' => '16',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Wash Pond 1',
                'detail' => 'Wash Pond 1',
                'status' => 'Active',
                'sequence' => '17',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Wash Pond 2',
                'detail' => 'Wash Pond 2',
                'status' => 'Active',
                'sequence' => '18',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Waste Sorting Conveyor ',
                'detail' => 'Waste Sorting Conveyor ',
                'status' => 'Active',
                'sequence' => '19',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Blancher 3 Conveyor ',
                'detail' => 'Blancher 3 Conveyor ',
                'status' => 'Active',
                'sequence' => '20',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Blancher 3',
                'detail' => 'Blancher 3',
                'status' => 'Active',
                'sequence' => '21',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Chiilling 3',
                'detail' => 'Chiilling 3',
                'status' => 'Active',
                'sequence' => '22',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Chilling 3 Export Conveyor ',
                'detail' => 'Chilling 3 Export Conveyor ',
                'status' => 'Active',
                'sequence' => '23',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'KeyShaker 3 Conveyor ',
                'detail' => 'KeyShaker 3 Conveyor ',
                'status' => 'Active',
                'sequence' => '24',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'KeyShaker 3',
                'detail' => 'KeyShaker 3',
                'status' => 'Active',
                'sequence' => '25',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Shaker IQF3',
                'detail' => 'Shaker IQF3',
                'status' => 'Active',
                'sequence' => '26',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'IQF3',
                'detail' => 'IQF3',
                'status' => 'Active',
                'sequence' => '27',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'IQF3 Export Conveyor ',
                'detail' => 'IQF3 Export Conveyor ',
                'status' => 'Active',
                'sequence' => '28',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => ' Autoweight 3 Conveyor ',
                'detail' => ' Autoweight 3 Conveyor ',
                'status' => 'Active',
                'sequence' => '29',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => ' Autoweight 3 Conveyor 2',
                'detail' => ' Autoweight 3 Conveyor 2',
                'status' => 'Active',
                'sequence' => '30',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => 'Autoweight 3',
                'detail' => 'Autoweight 3',
                'status' => 'Active',
                'sequence' => '31',
            ],
            [
                'department_id' => '1',
                'line_id' => '3',
                'name' => ' Autoweight 3 Export Conveyor ',
                'detail' => ' Autoweight 3 Export Conveyor ',
                'status' => 'Active',
                'sequence' => '32',
            ],


        ];

        foreach ($machines as $machine) {
            Machines::create($machine);
        }
    }
}
