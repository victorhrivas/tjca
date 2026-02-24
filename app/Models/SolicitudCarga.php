<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCarga extends Model
{
    protected $table = 'solicitud_cargas';

    protected $fillable = [
        'solicitud_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'integer',
        'subtotal' => 'integer',
    ];

    public function solicitud()
    {
        return $this->belongsTo(\App\Models\Solicitud::class);
    }
}
