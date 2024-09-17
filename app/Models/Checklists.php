<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklists extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'type',
        'seq',
        'name',
        'desc',
    ];

    public function checklist_plans()
    {
        return $this->hasMany(Checklist_plans::class);
    }

    public function checklist_plan_one()
    {
        return $this->hasOne(Checklist_plans::class, 'id', 'checklists_id');
    }
}
