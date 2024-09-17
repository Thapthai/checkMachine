<?php

namespace App\Models\ScheduleCheck;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleItems extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'schedule_items';
    protected $fillable = [
        'schedule_plan_id',
        'machine_id',
        'resin_id'
    ];
}
