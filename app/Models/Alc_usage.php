<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alc_usage extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'alc_usage';
    protected $fillable = [
        'alc_standard_id', 'used_quantity', 'shift_date', 'on_shift'
    ];

    public function alc_standard()
    {
        return $this->belongsTo(Alc_standard::class, 'alc_standard_id');
    }

    public function alc_checkings()
    {
        return $this->hasMany(Alc_checking::class, 'alc_usage_id');
    }

    public function alc_usage_bottles()
    {
        return $this->hasMany(Alc_usage_bottles::class, 'alc_usage_id');
    }
}
