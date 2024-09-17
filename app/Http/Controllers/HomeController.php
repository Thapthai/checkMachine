<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NewVersion\ResinController;
use App\Models\Departments;
use App\Models\ScheduleCheck\FrequencyChecks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $pageginate = '5';
    //     $departments = Departments::orderBy('id', 'desc')->paginate($pageginate);

    //     return view('home', compact('departments'));
    // }

    // new version
    public function index()
    {

        $departments = Departments::where('id', Auth::user()->department_id)->get();
        if (Auth::user()->is_admin) {
            $departments = Departments::all();
        }

        return view('NewVersion.selectApp', compact('departments'));
    }

    public function adminHome()
    {
        return view('adminHome');
    }

    public function appSelect(Departments $department, $app)
    {
        if ($app == 'resin') {
            $frequencyChecks = FrequencyChecks::all();
            $resinController = new ResinController;
            $appName = $resinController->appName($app);
            return view('NewVersion.app.resin.index', compact('department', 'app', 'appName', 'frequencyChecks'));
        } else {
            return redirect()->back()->with('error', 'Not available !!!');
        }
    }
}
