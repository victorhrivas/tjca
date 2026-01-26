<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEjecutivo extends Model
{
    protected $table = 'cliente_ejecutivos';

    protected $fillable = [
        'cliente_id',
        'nombre',
        'correo',
        'telefono',
        'cargo',
        'activo',
        'es_principal',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'es_principal' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
