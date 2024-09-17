<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Lines;
use App\Models\Machines;
use App\Models\Resins;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ResinsController extends Controller
{
    public function index($department_id, $line_id, Request $request) {}


    public function list($department_id, $line_id, Request $request) {}

    public function create($department_id) {}

    public function store(Departments $department, Lines $line, Machines $machine, Request $request)
    {

        $path = [];
        $name = [];
        $pics = [
            'pic1',
        ];

        $storage_path = storage_path('app/public/upload_imgs_resins/');

        foreach ($pics as $key => $picName) {
            if ($request->hasFile($picName)) {
                if (!is_dir($storage_path)) {
                    mkdir($storage_path, 0777, true);
                }

                $name = time() . $picName . '.' . $request->file($picName)->getClientOriginalExtension();
                $path[$key] = 'upload_imgs_resins/' . $name;

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


        Resins::create([
            'machines_id' => $machine->id,
            'detail' => $request->detail,
            'position' => $request->position,
            'total_resin' => $request->total_resin,
            'material' => $request->material,
            'color' => $request->color,
            'pic1' => $path[0],
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


    public function update($department_id, $line_id, Machines $machine, Request $request, Resins $resin)
    {

        $path = [];
        $storage_path = storage_path('app/public/upload_imgs_resins/');
        $pic = [
            'pic1',
        ];

        foreach ($pic as $i => $picName) {
            if ($request->hasFile($picName)) {
                // ลบไฟล์เดิมหากมี
                if (File::exists(public_path('storage/' . $resin->$picName))) {
                    File::delete(public_path('storage/' . $resin->$picName));
                }

                // ตรวจสอบและสร้าง directory หากไม่มี
                if (!File::exists($storage_path)) {
                    File::makeDirectory($storage_path, 0777, true);
                }

                // สร้างชื่อไฟล์ที่ไม่ซ้ำ
                $fileName = uniqid() . '.' . $request->file($picName)->getClientOriginalExtension();
                $path[$i] = 'upload_imgs_resins/' . $fileName;

                // สร้างภาพจากไฟล์ที่อัปโหลด
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
                $image->save($storage_path . $fileName);
            } else {
                $path[$i] = $resin->$picName;
            }
        }

        $resin->update([
            'machines_id' => $machine->id,
            'detail' => $request->detail,
            'position' => $request->position,
            'total_resin' => $request->total_resin,
            'material' => $request->material,
            'color' => $request->color,
            'pic1' => $path[0],
            'sequence' => $request->sequence,

        ]);

        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function destroy($department_id,  $line_id, Machines $machine, Resins $resin)
    {
        $pic = [
            $resin->pic1,
        ];

        foreach ($pic as $file) {
            if ($file && File::exists(public_path('storage/' . $file))) {
                File::delete(public_path('storage/' . $file));
            }
        }

        foreach ($resin->schedulePlans as $schedulePlan) {
            $schedulePlan->delete();
        }

        $resin->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
