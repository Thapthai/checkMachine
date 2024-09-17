<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';

    protected $fillable = [
        'id', 'name', 'desc', 'status'
    ];
}
