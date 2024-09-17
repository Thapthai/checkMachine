<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alc_broked_picture extends Model
{
    use HasFactory;
    protected $table = 'alc_broked_picture';
    protected $connection = 'sqlsrv';


    protected $fillable = [
        'alc_broked_id', 'path'
    ];

    public function alc_broked()
    {
        return $this->belongsTo(Alc_broked::class, 'alc_broked_id');
    }
}
