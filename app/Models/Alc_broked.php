<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alc_broked extends Model
{
    use HasFactory;
    protected $table = 'alc_broked';
    protected $connection = 'sqlsrv';

    protected $fillable = [
        'alc_checking_id', 'alc_usage_bottle_id', 'detail', 'shift_date', 'on_shift'
    ];

    public function alc_checking()
    {
        return $this->belongsTo(Alc_checking::class, 'alc_checking_id');
    }

    public function alc_broked_pictures()
    {
        return $this->hasMany(Alc_broked_picture::class, 'alc_broked_id');
    }
    public function alc_usage_bottle()
    {
        return $this->hasOne(Alc_usage_bottles::class, 'id', 'alc_usage_bottle_id');
    }
}
