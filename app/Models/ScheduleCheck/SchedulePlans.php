<?php

namespace App\Models\ScheduleCheck;

use App\Models\Lines;
use App\Models\Resins;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulePlans extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'schedule_plans';
    protected $fillable = [
        'line_id',
        'machine_id',
        'frequency_check_id',
        'resin_id',
        'define'
    ];

    public function resin()
    {
        return $this->hasOne(Resins::class, 'id', 'resin_id');
    }

    public function frequency_check()
    {
        return $this->hasOne(FrequencyChecks::class, 'id', 'frequency_check_id');
    }

    public function line()
    {
        return $this->belongsTo(Lines::class, 'line_id');
    }

    public function ScheduleRecords()
    {
        return $this->hasMany(ScheduleRecords::class, 'schedule_plan_id');
    }
}
