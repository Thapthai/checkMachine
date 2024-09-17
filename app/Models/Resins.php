<?php

namespace App\Models;

use App\Models\ScheduleCheck\SchedulePlans;
use App\Models\ScheduleCheck\ScheduleRecords;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resins extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';

    protected $fillable = [
        'machines_id',
        'detail',
        'position',
        'total_resin',
        'material',
        'color',
        'pic1',
        'pic2',
        'pic3',
        'sequence',
    ];


    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machines_id');
    }

    public function resin_records()
    {
        return $this->hasMany(Resin_records::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repairs::class);
    }

    public function schedulePlans()
    {
        return $this->hasMany(SchedulePlans::class, 'resin_id');
    }

    public function schedule_records()
    {
        return $this->hasMany(ScheduleRecords::class,  'resin_id');
    }
}
