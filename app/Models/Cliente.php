<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $table = 'clientes';

    public $fillable = [
        'razon_social',
        'rut',
        'correo',
        'telefono',
        'direccion',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'razon_social' => 'string',
        'rut' => 'string',
        'correo' => 'string',
        'telefono' => 'string',
        'direccion' => 'string'
    ];

    public static array $rules = [
        'razon_social' => 'required'
    ];

    
}
