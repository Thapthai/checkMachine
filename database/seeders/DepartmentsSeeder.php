<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $departments = [
            [
                'name' => 'PF',
                'status' => 'Active',
                'detail' => 'แผนก PF',
            ],
            [
                'name' => 'PK',
                'status' => 'Active',
                'detail' => 'แผนก PK',
            ],
            [
                'name' => 'RTE',
                'status' => 'Active',
                'detail' => 'แผยก RTE',
            ],
        ];

        foreach ($departments as $department) {
            Departments::create($department);
        }
    }
}
