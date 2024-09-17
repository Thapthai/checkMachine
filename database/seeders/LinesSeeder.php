<?php

namespace Database\Seeders;

use App\Models\Lines;
use Illuminate\Database\Seeder;

class LinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lines = [
            // PF : 1
            [
                'name' => 'Line 1',
                'department_id' => '1',
                'status' => 'Active',
                'detail' => 'Line 1',
            ],
            [
                'name' => 'Line 2',
                'department_id' => '1',
                'status' => 'Active',
                'detail' => 'Line 2',
            ],
            [
                'name' => 'Line 3',
                'department_id' => '1',
                'status' => 'Active',
                'detail' => 'Line 3',
            ],
            [
                'name' => 'Line รีด',
                'department_id' => '1',
                'status' => 'Active',
                'detail' => 'Line รีด',
            ],
            [
                'name' => 'Line กล้วย',
                'department_id' => '1',
                'status' => 'Active',
                'detail' => 'Line กล้วย',
            ],

            // PK : 2
            [
                'name' => 'Auto 1',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Auto 1',
            ],
            [
                'name' => 'Auto 2',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Auto 2',
            ],
            [
                'name' => 'Auto 3',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Auto 3',
            ],
            [
                'name' => 'Auto 4',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Auto 4',
            ],
            [
                'name' => 'Auto 5',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Auto 1',
            ],
            [
                'name' => 'Manual',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Manual',
            ],
            [
                'name' => 'Line คัด',
                'department_id' => '2',
                'status' => 'Active',
                'detail' => 'Line คัด',
            ],

            // RTE : 3

            [
                'name' => 'RTE ชั้น 1',
                'department_id' => '3',
                'status' => 'Active',
                'detail' => 'RTE ชั้น 1',
            ],
            [
                'name' => 'RTE ชั้น 2',
                'department_id' => '3',
                'status' => 'Active',
                'detail' => 'RTE ชั้น 3',
            ],
            [
                'name' => 'RTE ชั้น 3',
                'department_id' => '3',
                'status' => 'Active',
                'detail' => 'RTE ชั้น 3',
            ],

        ];

        foreach ($lines as $line) {
            Lines::create($line);
        }
    }
}
