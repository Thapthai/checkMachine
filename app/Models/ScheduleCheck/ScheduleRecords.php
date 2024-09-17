<?php

namespace App\Models\ScheduleCheck;

use App\Models\Resins;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRecords extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'schedule_records';

    protected $fillable = [
        'schedule_plan_id',
        'resin_id',
        'complete',
        'clean',
        'by_user',
        'on_shift',
        'check_in',
        'shift_date',
        'detail',
        'pic1',
        'pic2',
        'pic3',
        'status',
        'repair_date',
    ];

    public function resin()
    {
        return $this->belongsTo(Resins::class, 'resin_id');
    }

    public function schedule_plan()
    {
        return $this->belongsTo(SchedulePlans::class, 'schedule_plan_id');
    }

    public function approve()
    {
        return $this->hasOne(Approve::class, 'schedule_record_id', 'id');
    }
}
