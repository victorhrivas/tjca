<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $table = 'clientes';

    protected $fillable = [
        'razon_social',
        'rut',
        'giro',
        'correo',
        'telefono',
        'direccion',
    ];

    protected $casts = [
        'razon_social' => 'string',
        'rut' => 'string',
        'giro' => 'string',
        'correo' => 'string',
        'telefono' => 'string',
        'direccion' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static array $rules = [
        'razon_social' => 'required',
    ];
}
