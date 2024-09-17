<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part_records extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'machines_id',
        'parts_id',
        'checklist_id',
        'checklist_plans_id',
        'status',
        'by_user',
        'detail',
        'pic1',
        'pic2',
        'pic3',
        'repair_date',
    ];



    public function user()
    {
        return $this->hasOne(User::class, 'id', 'by_user');
    }
    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machines_id');
    }

    public function part()
    {
        return $this->belongsTo(Parts::class, 'parts_id');
    }
    public function checklist()
    {
        return $this->belongsTo(Checklists::class, 'checklist_id');
    }

    public function checklist_plan()
    {
        return $this->hasOne(Checklist_plans::class, 'id', 'checklist_plans_id');
    }
}
