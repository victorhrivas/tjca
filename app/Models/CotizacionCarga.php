<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionCarga extends Model
{
    protected $table = 'cotizacion_cargas';

    protected $fillable = [
        'cotizacion_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'cotizacion_id',
    ];


    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'integer',
        'subtotal' => 'integer',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(\App\Models\Cotizacion::class);
    }
}
