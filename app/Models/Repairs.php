<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repairs extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $fillable = [
        'parts_id',
        'resins_id',

        'departments_id',
        'machines_id',
        'line_id',

        'status',
        'by_user',
        'on_shift',
        'detail',

        'pic_before',
        'pic_after',
        'pic',
        'created_at'

    ];

    public function part()
    {
        return $this->belongsTo(Parts::class, 'parts_id');
    }
    public function resin()
    {
        return $this->belongsTo(Resins::class, 'resins_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'by_user');
    }
}
