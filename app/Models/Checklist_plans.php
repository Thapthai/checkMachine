<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist_plans extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';

    protected $fillable = [
        'checklists_id',
        'parts_id',
        'detail',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklists::class, 'checklists_id');
    }

    public function part_record()
    {
        return $this->hasOne(Part_records::class, 'checklist_plans_id', 'id');
    }

    public function part()
    {
        return $this->belongsTo(Parts::class, 'parts_id');
    }
}
