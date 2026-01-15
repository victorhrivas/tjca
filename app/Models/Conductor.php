<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    public $table = 'conductors';

    public $fillable = [
        'nombre',
        'rut',
        'telefono',
        'correo',
        'licencia',
        'activo'
    ];

    protected $casts = [
        'nombre' => 'string',
        'rut' => 'string',
        'telefono' => 'string',
        'correo' => 'string',
        'licencia' => 'string',
        'activo' => 'boolean'
    ];

    public static array $rules = [
        'nombre' => 'required'
    ];
}
