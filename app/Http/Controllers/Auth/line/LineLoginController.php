<?php

namespace App\Http\Controllers\Auth\line;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LineLoginController extends Controller
{
    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('line')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('line')->user();

        $lineId = $user->getId();

        // ค้นหาผู้ใช้ที่มีอยู่ในฐานข้อมูล
        $existingUser = User::where('line_id', $lineId)->first();

        if (!$existingUser) {
            $newUser = new User();
            $newUser->is_admin = 1;
            $newUser->name = $user->getName();
            $newUser->username = $user->getName();
            $newUser->email = $user->getEmail(); // ถ้ามี
            $newUser->line_id = $lineId;
            $newUser->save();

            Auth::login($newUser);
            auth()->login($newUser);
        } else {
            Auth::login($existingUser);
            auth()->login($existingUser);
        }

        if (auth()->user()->is_admin == 1) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('user.home');
        }
    }

    // public function handleLineCallback()
    // {
    //     try {
    //         $user = Socialite::driver('line')->user();
    //         $finduser = AuthProvider::where('provider', 'line')->where('provider_id', $user->id)->first();
    //         if ($finduser) {
    //             $user = User::where('id', $finduser->user_id)->first();
    //             Auth::login($user);
    //             return redirect('/');
    //         } else {
    //             $newUser = new User();
    //             $newUser->name = $user->name ? $user->name : $user->nickname;
    //             $newUser->email = $user->email;
    //             $newUser->save();
    //             $newUser->assignRole('Member');

    //             $new_user = new AuthProvider();
    //             $new_user->user_id = $newUser->id;
    //             $new_user->provider = 'line';
    //             $new_user->provider_id = $user->id;
    //             $new_user->save();
    //             Auth::login($newUser);
    //             return redirect('/');
    //         }
    //     } catch (Exception $e) {
    //         Log::error($e->getMessage());
    //         return redirect('/');
    //     }
    // }
}
