<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resin_records extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'machines_id',
        'resins_id',
        'status',
        'clean',
        'detail',
        'by_user',
        'shift_date',
        'on_shift',
        'check_in',
        'pic1',
        'pic2',
        'pic3',
        'repair_date',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'by_user');
    }

    public function resin()
    {
        return $this->belongsTo(Resins::class, 'resins_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machines_id');
    }
}
