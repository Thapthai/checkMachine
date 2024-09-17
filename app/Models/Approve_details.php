<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve_details extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'approve_details';

    protected $fillable = [
        'approve_id',
        'machine_id',
        'resin_record_id',
        'part_record_id'
    ];


    public function resin_record()
    {
        return $this->belongsTo(Resin_records::class, 'resin_record_id');
    }

    public function part_record()
    {
        return $this->belongsTo(Part_records::class, 'part_record_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machine_id');
    }
}
