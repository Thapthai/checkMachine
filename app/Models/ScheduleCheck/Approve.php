<?php

namespace App\Models\ScheduleCheck;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'approve';
    protected $fillable = [
        'schedule_record_id',
        'status',
        'detail',
        'user_approve'
    ];

    public function ScheduleRecord()
    {
        return $this->hasOne(ScheduleRecords::class,  'id', 'schedule_record_id');
    }
}
