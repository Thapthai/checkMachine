<?php

namespace Database\Seeders;

use App\Models\Resins;
use Illuminate\Database\Seeder;

class ResinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resins = [

            //Feeding Conveyor 1 |id:1
            [
                'machines_id' => '1',
                'sequence' => '1',
                'detail' => '',
                'material' => 'PE',
                'color' => 'White',
                'position' => 'left-right side',
                'total_resin' => '2'
            ],
            [
                'machines_id' => '1',
                'sequence' => '2',
                'position' => 'inside neary belt',
                'total_resin' => '2',
                'material' => 'Superlene',
                'color' => 'White',
                'detail' => '',
            ],

            [
                'machines_id' => '1',
                'sequence' => '3',
                'position' => 'belt',
                'total_resin' => '1',
                'material' => 'PU',
                'color' => 'White',
                'detail' => '',
            ],
            [
                'machines_id' => '1',
                'sequence' => '4',
                'position' => ' left-right side',
                'total_resin' => '3',
                'material' => 'PE',
                'color' => 'White',
                'detail' => '',
            ],
            [
                'machines_id' => '1',
                'sequence' => '5',
                'position' => 'inside neary belt',
                'total_resin' => '1',
                'material' => 'PU',
                'color' => 'Blue',
                'detail' => '',
            ],
            [
                'machines_id' => '1',
                'sequence' => '6',
                'position' => 'left-right side',
                'total_resin' => '8',
                'material' => 'PE',
                'color' => 'Grey',
                'detail' => '',
            ],
            [
                'machines_id' => '1',
                'sequence' => '7',
                'position' => 'top side',
                'total_resin' => '2',
                'material' => 'PE',
                'color' => 'Red,Yellow',
                'detail' => '',
            ],
            // Feeding Conveyor 2 | id:2
            [
                'machines_id' => '2',
                'sequence' => '1',
                'position' => 'left-right side',
                'total_resin' => '2',
                'material' => 'PE',
                'color' => 'White',
                'detail' => '',
            ],

            [
                'machines_id' => '2',
                'sequence' => '2',
                'position' => 'neary belt',
                'total_resin' => '1',
                'material' => 'PE',
                'color' => 'Green',
                'detail' => '',
            ],
            [
                'machines_id' => '2',
                'sequence' => '3',
                'position' => 'outside neary belt',
                'total_resin' => '1',
                'material' => 'PU',
                'color' => 'Blue',
                'detail' => '',
            ],
            [
                'machines_id' => '2',
                'sequence' => '4',
                'position' => 'inside neary belt',
                'total_resin' => '2',
                'material' => 'PU',
                'color' => 'Blue',
                'detail' => '',
            ],
            [
                'machines_id' => '2',
                'sequence' => '5',
                'position' => 'neary belt',
                'total_resin' => '4',
                'material' => 'PE',
                'color' => 'Green',
                'detail' => '',
            ],
            [
                'machines_id' => '2',
                'sequence' => '6',
                'position' => 'neary belt',
                'total_resin' => '9',
                'material' => 'PE',
                'color' => 'Yellow,Black',
                'detail' => '',
            ],
            [
                'machines_id' => '2',
                'sequence' => '7',
                'position' => 'left-right side',
                'total_resin' => '2',
                'material' => 'PE',
                'color' => 'White',
                'detail' => '',
            ],
            // Blower Conveyor 3 |id:3
            [
                'machines_id' => '3',
                'sequence' => '1',
                'position' => ' left-right side',
                'total_resin' => '3',
                'material' => 'PE',
                'color' => 'White',
                'detail' => '',
            ],
            [
                'machines_id' => '3',
                'sequence' => '2',
                'position' => 'inside neary belt',
                'total_resin' => '1',
                'material' => 'PE',
                'color' => 'Green',
                'detail' => '',
            ],

        ];

        foreach ($resins as $resin) {
            Resins::create($resin);
        }
    }
}
