<?php

namespace Database\Seeders;

use App\Models\Checklists;
use Illuminate\Database\Seeder;

class Check_listsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checklist = [
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '1',
                'name' => 'น๊อต,สกรู, รีเวตยึดสายพาน และอื่นๆ',
                'desc' => 'น๊อต,สกรู, รีเวตยึดสายพาน และอื่นๆ',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '2',
                'name' => 'สายพาน , ใบมีด/ใบพัด',
                'desc' => 'สายพาน , ใบมีด/ใบพัด',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '3',
                'name' => 'สวิตซ์ควบคุมการทำงาน, วาล์ว, สายไฟ,แผงหน้าจอควบคุม,หลอดไฟ',
                'desc' => 'สวิตซ์ควบคุมการทำงาน, วาล์ว, สายไฟ,แผงหน้าจอควบคุม,หลอดไฟ',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '4',
                'name' => 'ฝาครอบมอเตอร์,safe guard , ตะแกรง',
                'desc' => 'ฝาครอบมอเตอร์,safe guard , ตะแกรง',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '5',
                'name' => 'มอเตอร์,ปั๊ม,โซ่และเฟือง',
                'desc' => 'มอเตอร์,ปั๊ม,โซ่และเฟือง',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '6',
                'name' => 'ซุปเปอร์ลีน,บั้ง,แผ่นสแตนเลส , แผ่นพลาสติกที่สายพาน',
                'desc' => 'ซุปเปอร์ลีน,บั้ง,แผ่นสแตนเลส , แผ่นพลาสติกที่สายพาน',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '7',
                'name' => 'จารบี',
                'desc' => 'จารบี',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '8',
                'name' => 'วาล์ว ปิด-เปิดน้ำ',
                'desc' => 'วาล์ว ปิด-เปิดน้ำ',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '9',
                'name' => 'เทอร์โมมิเตอร์ ,เกจวัด , ไฟ alarm , พลาสติกแข็ง',
                'desc' => 'เทอร์โมมิเตอร์ ,เกจวัด , ไฟ alarm , พลาสติกแข็ง',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '10',
                'name' => 'ขาเครื่องชั่ง, แผ่นรองชั่ง',
                'desc' => 'ขาเครื่องชั่ง, แผ่นรองชั่ง',
            ],
            [
                'type' => 'ส่วนเตรียมการ',
                'seq' => '11',
                'name' => 'ความสะอาด',
                'desc' => 'ความสะอาด',
            ],
        ];
        foreach ($checklist as $key => $value) {
            Checklists::create($value);
        }
    }
}
