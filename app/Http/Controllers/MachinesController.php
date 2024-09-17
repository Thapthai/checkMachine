<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class MachinesController extends Controller
{
    public function index($department_id, $line_id, Request $request) {}


    public function list($department_id, $line_id, Request $request) {}

    public function create($department_id)
    {
        return view('machines.create', compact('department_id'));
    }

    public function store($department_id, $line_id, Request $request)
    {
        $path = [];
        $name = [];
        $pics = [
            'pic_1',
            'pic_2',
            'pic_3',
            'pic_4',
            'pic_5',
            'pic_6',
            'pic_7',
            'pic_8',
            'pic_9',
            'pic_10',
        ];

        $storage_path = storage_path('app/public/upload_imgs_machine/');

        foreach ($pics as $key => $picName) {
            if ($request->hasFile($picName)) {
                if (!is_dir($storage_path)) {
                    mkdir($storage_path, 0777, true);
                }

                $name = time() . $picName . '.' . $request->file($picName)->getClientOriginalExtension();
                $path[$key] = 'upload_imgs_machine/' . $name;

                $image = Image::make($request->file($picName));

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


        Machines::create([
            'department_id' => $department_id,
            'line_id' => $line_id,
            'name' => $request->name,
            'status' => $request->status,
            'detail' => $request->detail,
            'pic1' => $path[0],
            'pic2' => $path[1],
            'pic3' => $path[2],
            'pic4' => $path[3],
            'pic5' => $path[4],
            'pic6' => $path[5],
            'pic7' => $path[6],
            'pic8' => $path[7],
            'pic9' => $path[8],
            'pic10' => $path[9],
            'sequence' => $request->sequence,
        ]);

        return redirect()->back()->with('success', 'Created successfully.');
    }
    public function edit($department_id, $onshift, $selected, $line_id, $shiftDate, Machines $machine)
    {

        $department = Departments::findOrFail($department_id);
        $line = Lines::findOrFail($line_id);

        return view('machines.edit', compact('department', 'onshift', 'selected', 'line', 'shiftDate', 'machine'));
    }


    public function update(Departments $department, Lines $line, Request $request, Machines $machine)
    {

        $path = [];
        $storage_path = storage_path('app/public/upload_imgs_machine/');


        $pic = [
            'pic1',
            'pic2',
            'pic3',
            'pic4',
            'pic5',
            'pic6',
            'pic7',
            'pic8',
            'pic9',
            'pic10',
        ];

        foreach ($pic as $key => $picName) {
            if ($request->hasFile($picName)) {
                // ลบไฟล์เดิมหากมี
                if (File::exists(public_path('storage/' . $machine->$picName))) {
                    File::delete(public_path('storage/' . $machine->$picName));
                }

                // ตรวจสอบและสร้าง directory หากไม่มี
                if (!File::exists($storage_path)) {
                    File::makeDirectory($storage_path, 0777, true);
                }

                // สร้างชื่อไฟล์ที่ไม่ซ้ำ
                $name = uniqid() . '.' . $request->file($picName)->getClientOriginalExtension();
                $path[$key] = 'upload_imgs_machine/' . $name;


                $image = Image::make($request->file($picName));

                // ปรับหมุนภาพตามค่า EXIF
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

                // ปรับขนาดภาพให้สูงสุดอยู่ที่ 300 พิกเซล โดยรักษาสัดส่วนเดิม
                $image->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // บันทึกภาพ
                $image->save($storage_path . $name);
            } else {
                $path[$key] = $machine->$picName;
            }
        }

        $machine->update([
            'department_id' => $department->id,
            'line_id' => $line->id,
            'name' => $request->name,
            'status' => $request->status,
            'detail' => $request->detail,
            'pic1' => $path[0],
            'pic2' => $path[1],
            'pic3' => $path[2],
            'pic4' => $path[3],
            'pic5' => $path[4],
            'pic6' => $path[5],
            'pic7' => $path[6],
            'pic8' => $path[7],
            'pic9' => $path[8],
            'pic10' => $path[9],
            'sequence' => $request->sequence,
        ]);

        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function destroy(Departments $department, Lines $line, Machines $machine)
    {
        $pic = [
            $machine->pic1,
            $machine->pic2,
            $machine->pic3,
            $machine->pic4,
            $machine->pic5,
            $machine->pic6,
            $machine->pic7,
            $machine->pic8,
            $machine->pic9,
            $machine->pic10,
        ];

        foreach ($pic as $file) {
            if ($file && File::exists(public_path('storage/' . $file))) {
                File::delete(public_path('storage/' . $file));
            }
        }

        foreach ($machine->resins as $resin) {
            foreach ($resin->schedulePlans as $schedulePlan) {
                $schedulePlan->delete();
            }
            $resin->delete();
        }

        $machine->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
