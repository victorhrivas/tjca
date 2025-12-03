<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifaRuta extends Model
{
    public $table = 'tarifa_rutas';

    public $fillable = [
        'origen',
        'destino',
        'km',
        'cama_baja_25_ton',
        'rampla_autodescargable',
        'rampla_plana',
        'autodescargable_10_ton'
    ];

    protected $casts = [
        'origen' => 'string',
        'destino' => 'string',
        'km' => 'integer',
        'cama_baja_25_ton' => 'integer',
        'rampla_autodescargable' => 'integer',
        'rampla_plana' => 'integer',
        'autodescargable_10_ton' => 'integer'
    ];

    public static array $rules = [
        'origen' => 'required',
        'destino' => 'required'
    ];

    
}
