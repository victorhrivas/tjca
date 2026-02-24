<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    public $table = 'vehiculos';

    public $fillable = [
        'marca',
        'modelo',
        'anio',
        'patente',
        'informacion_general'
    ];

    protected $casts = [
        'marca' => 'string',
        'modelo' => 'string',
        'anio' => 'integer',
        'patente' => 'string',
        'informacion_general' => 'string'
    ];

    public static array $rules = [
        'marca' => 'required',
        'modelo' => 'required',
        'anio' => 'required|integer',
        'patente' => 'required|unique:vehiculos,patente'
    ];

    
}
