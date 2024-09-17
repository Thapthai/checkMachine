<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parts extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'machines_id',
        'name',
        'detail',
        'status',
        'pic1',
        'sequence',
    ];

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machines_id');
    }
    public function part_records()
    {
        return $this->hasMany(Part_records::class);
    }

    public function checklist_plans()
    {
        return $this->hasMany(Checklist_plans::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repairs::class);
    }
}
