<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'shifts';

    protected $fillable = [
        'id', 'department_id', 'time_start', 'time_end', 'name', 'desc', 'status'
    ];
}
