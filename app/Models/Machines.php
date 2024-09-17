<?php

namespace App\Models;

use App\Models\ScheduleCheck\SchedulePlans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'department_id',
        'line_id',
        'name',
        'status',
        'detail',
        'pic1',
        'pic2',
        'pic3',
        'sequence',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class,  'department_id', 'id');
    }

    public function line()
    {
        return $this->belongsTo(Lines::class, 'line_id');
    }

    public function parts()
    {
        return $this->hasMany(Parts::class);
    }
    public function part_records()
    {
        return $this->hasMany(Part_records::class);
    }

    public function resins()
    {
        return $this->hasMany(Resins::class, 'machines_id');
    }
    public function resin_records()
    {
        return $this->hasMany(Resin_records::class);
    }

    public function schedulePlans()
    {
        return $this->hasMany(SchedulePlans::class, 'machine_id');
    }
}
