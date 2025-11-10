<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ot extends Model
{
    public $table = 'ots';

    public $fillable = [
        'cotizacion_id',
        'conductor',
        'patente_camion',
        'patente_remolque',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'cotizacion_id' => 'integer',
        'conductor' => 'string',
        'patente_camion' => 'string',
        'patente_remolque' => 'string',
        'estado' => 'string'
    ];

    public static array $rules = [
        'cotizacion_id' => 'required'
    ];

    
}
