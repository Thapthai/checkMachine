<?php

namespace App\Models\ScheduleCheck;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequencyChecks extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'frequency_checks';
    protected $fillable = ['name'];



    public function schedulePlans()
    {
        return $this->hasMany(SchedulePlans::class, 'frequency_check_id');
    }
}
