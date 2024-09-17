<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'name',
        'status',
        'detail',
    ];


    public function shifts()
    {
        return $this->hasMany(Shifts::class, 'department_id');
    }

    public function machines()
    {
        return $this->hasMany(Machines::class, 'department_id');
    }

    public function lines()
    {
        return $this->hasMany(Lines::class, 'department_id');
    }

    public function alc_standard()
    {
        return $this->hasMany(Alc_standard::class, 'department_id');
    }

    public function alc_bottles()
    {
        return $this->hasMany(Alc_bottles::class, 'department_id');
    }
}
