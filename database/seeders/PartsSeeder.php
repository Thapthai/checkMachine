<?php

namespace Database\Seeders;

use App\Models\Parts;
use Illuminate\Database\Seeder;

class PartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            [
                'machines_id' => '1',
                'name' => 'สายพานปล่อยถั่วไลน์',
                'detail' => 'สายพานปล่อยถั่วไลน์',
                'sequence' => '1',

            ],
            [
                'machines_id' => '1',
                'name' => 'สายพาน + เครื่องลวก ไลน์ HI',
                'detail' => 'สายพาน + เครื่องลวก ไลน์ HI',
                'sequence' => '2',

            ],
            [
                'machines_id' => '1',
                'name' => 'สายพาน + บ่อน้ำเย็น ไลน์ HI',
                'detail' => 'สายพาน + บ่อน้ำเย็น ไลน์ HI',
                'sequence' => '3',

            ],
            [
                'machines_id' => '1',
                'name' => 'สายพานรับถั่วจากบ่อน้ำเย็นไลน์ HI',
                'detail' => 'สายพานรับถั่วจากบ่อน้ำเย็นไลน์ HI',
                'sequence' => '4',

            ],
            [
                'machines_id' => '1',
                'name' => 'สายพาน Auto Feedไลน์ HI',
                'detail' => 'สายพาน Auto Feedไลน์ HI',
                'sequence' => '5',

            ],
            [
                'machines_id' => '1',
                'name' => 'ใบพัดลงเครื่องรีดเมล็ด 1ไลน์ HI',
                'detail' => 'ใบพัดลงเครื่องรีดเมล็ด 1ไลน์ HI',
                'sequence' => '6',

            ],
            [
                'machines_id' => '1',
                'name' => 'ใบพัดลงเครื่องรีดเมล็ด 2ไลน์ HI',
                'detail' => 'ใบพัดลงเครื่องรีดเมล็ด 2ไลน์ HI',
                'sequence' => '7',

            ],
            [
                'machines_id' => '1',
                'name' => 'ใบพัดลงเครื่องรีดเมล็ด 3ไลน์ HI',
                'detail' => 'ใบพัดลงเครื่องรีดเมล็ด 3ไลน์ HI',
                'sequence' => '8',

            ],
            [
                'machines_id' => '1',
                'name' => 'ใบพัดลงเครื่องรีดเมล็ด 4ไลน์ HI',
                'detail' => 'ใบพัดลงเครื่องรีดเมล็ด 4ไลน์ HI',
                'sequence' => '9',

            ],
            [
                'machines_id' => '1',
                'name' => 'เครื่องรีดเมล็ด 1ไลน์ HI',
                'detail' => 'เครื่องรีดเมล็ด 1ไลน์ HI',
                'sequence' => '10',

            ],
            [
                'machines_id' => '1',
                'name' => 'เครื่องรีดเมล็ด 2ไลน์ HI',
                'detail' => 'เครื่องรีดเมล็ด 2ไลน์ HI',
                'sequence' => '11',

            ],
            [
                'machines_id' => '1',
                'name' => 'เครื่องรีดเมล็ด 3ไลน์ HI',
                'detail' => 'เครื่องรีดเมล็ด 3ไลน์ HI',
                'sequence' => '12',

            ],
            [
                'machines_id' => '1',
                'name' => 'เครื่องรีดเมล็ด 4ไลน์ HI',
                'detail' => 'เครื่องรีดเมล็ด 4ไลน์ HI',
                'sequence' => '13',

            ],
            [
                'machines_id' => '1',
                'name' => 'เครื่องรีดเมล็ด 5ไลน์ HI',
                'detail' => 'เครื่องรีดเมล็ด 5ไลน์ HI',
                'sequence' => '14',

            ],
            [
                'machines_id' => '1',
                'name' => 'สายพาน 2 ชั้นแยกเมล็ด และเปลือกถั่วไลน์ HI',
                'detail' => 'สายพาน 2 ชั้นแยกเมล็ด และเปลือกถั่วไลน์ HI',
                'sequence' => '15',

            ],
            [
                'machines_id' => '1',
                'name' => 'สายพานรับเมล็ดถั่วแระไลน์ HIไลน์ HI',
                'detail' => 'สายพานรับเมล็ดถั่วแระไลน์ HIไลน์ HI',
                'sequence' => '16',

            ],

        ];
        foreach ($parts as $key => $value) {
            Parts::create($value);
        }
    }
}