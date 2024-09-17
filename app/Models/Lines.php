<?php

namespace App\Models;

use App\Models\ScheduleCheck\SchedulePlans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lines extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $fillable = [
        'department_id',
        'name',
        'status',
        'detail',
    ];
    public function machines()
    {
        return $this->hasMany(Machines::class, 'line_id');
    }

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function alc_standard()
    {
        return $this->hasMany(Alc_standard::class, 'line_id');
    }

    public function schedulePlans()
    {
        return $this->hasMany(SchedulePlans::class, 'line_id');
    }
}
