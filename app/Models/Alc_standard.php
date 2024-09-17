<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alc_standard extends Model
{

    use HasFactory;
    protected $table = 'alc_standard';

    protected $connection = 'sqlsrv';

    protected $fillable = [
        'department_id', 'line_id', 'name', 'type', 'quantity',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function line()
    {
        return $this->belongsTo(Lines::class, 'line_id');
    }

    public function alc_usage()
    {
        return $this->hasMany(Alc_usage::class, 'alc_standard_id');
    }
}
