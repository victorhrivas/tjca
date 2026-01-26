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
        'razon_social' => 'required|string|max:255',
        'rut' => 'nullable|string|max:50',
        'giro' => 'nullable|string|max:255',
        'correo' => 'nullable|email|max:255',
        'telefono' => 'nullable|string|max:50',
        'direccion' => 'nullable|string|max:255',
    ];
    
    public function ejecutivos()
    {
        return $this->hasMany(\App\Models\ClienteEjecutivo::class, 'cliente_id');
    }

    public function ejecutivosActivos()
    {
        return $this->hasMany(\App\Models\ClienteEjecutivo::class, 'cliente_id')
            ->where('activo', true);
    }

    public function ejecutivoPrincipal()
    {
        return $this->hasOne(\App\Models\ClienteEjecutivo::class, 'cliente_id')
            ->where('es_principal', true)
            ->where('activo', true);
    }

}
