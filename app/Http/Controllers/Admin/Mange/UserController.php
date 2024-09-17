<?php

namespace App\Http\Controllers\Admin\Mange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function add_user($department_id, Request $request)
    {
        if ($request) {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|string|email|max:255|unique:users,email',
            ]);
            // Create a new user with a default password
            User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make('password'), // Set a default password
                'department_id' => $department_id,
                'is_admin' => '0'
            ]);

            return redirect()->back()->with('success', 'เพิ่มผู้ใช้งาน สำเร็จ');
        } else {
            return redirect()->back()->with('error', 'ไม่สามารถเพิ่มผู้ใช้งานได้: ');
        }
    }

    public function edit_user($department_id, User $user, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        try {

            $user->update($validatedData);

            return redirect()->back()->with('success', 'แก้ไขข้อมูลผู้ใช้งานสำเร็จ');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ไม่สามารถแก้ไขข้อมูลผู้ใช้งานได้: ' . $e->getMessage());
        }
    }

    public function destroy_user($department_id, User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'ลบ สำเร็จ');
    }
}
