<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alc_checking extends Model
{
    use HasFactory;
    protected $table = 'alc_checking';
    protected $connection = 'sqlsrv';

    protected $fillable = [
        'alc_usage_id', 'quantity_alc_usage', 'quantity_alc_broked', 'status', 'detail', 'shift_date', 'on_shift'
    ];

    public function alc_usage_join()
    {
        return $this->belongsTo(Alc_usage::class, 'alc_usage_id');
    }

    public function alc_brokeds()
    {
        return $this->hasMany(Alc_broked::class, 'alc_checking_id');
    }

    public function alc_normals()
    {
        return $this->hasMany(Alc_normal::class, 'alc_checking_id');
    }
}
