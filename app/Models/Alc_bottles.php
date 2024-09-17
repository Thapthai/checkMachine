<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Alc_bottles extends Model
{
    use HasFactory;
    protected $table = 'alc_bottles';
    protected $connection = 'sqlsrv';


    protected $fillable = [
        'bottle_no',
        'name',
        'type',
        'department_id',
        'line_id',
        'volume',
        'status',
        'unit_id'
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function line()
    {
        return $this->belongsTo(Lines::class, 'line_id');
    }

    public function unit()
    {
        return $this->hasOne(Units::class, 'id', 'unit_id');
    }

    public function getBarcodeAttribute()
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($this->id, $generator::TYPE_CODE_128);
        return 'data:image/png;base64,' . base64_encode($barcode);
    }
}
