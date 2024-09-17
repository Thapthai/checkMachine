<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alc_usage_bottles extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';

    protected $table = 'alc_usage_bottles';
    protected $fillable = [
        'alc_bottle_id', 'alc_usage_id'
    ];

    public function alc_bottle()
    {
        return $this->belongsTo(Alc_bottles::class, 'alc_bottle_id');
    }

    public function alc_usage()
    {
        return $this->belongsTo(Alc_usage::class, 'alc_usage_id');
    }
}
