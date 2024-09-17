<?php

namespace App\Http\Controllers\ScheduleCheck;

use App\Http\Controllers\Controller;
use App\Models\ScheduleCheck\FrequencyChecks;
use Illuminate\Http\Request;

class FrequencyCheckController extends Controller
{
    public function index()
    {

        $frequencyChecks = FrequencyChecks::all();

        return view('ScheduleCheck.frequencyCheck.index', compact('frequencyChecks'));
    }
}
