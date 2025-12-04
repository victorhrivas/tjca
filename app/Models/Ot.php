<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ot extends Model
{
    public $table = 'ots';

    public $fillable = [
        'cotizacion_id',
        'conductor',
        'contacto_origen',
        'contacto_destino',
        'link_mapa',
        'patente_camion',
        'patente_remolque',
        'estado',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'cotizacion_id'    => 'integer',
        'conductor'        => 'string',
        'contacto_origen'  => 'string',
        'contacto_destino' => 'string',
        'link_mapa' => 'string',
        'patente_camion'   => 'string',
        'patente_remolque' => 'string',
        'estado'           => 'string',
    ];

    public static array $rules = [
        'cotizacion_id' => 'required',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(\App\Models\Cotizacion::class);
    }

    public function getEstadoLabelAttribute()
    {
        return match ($this->estado) {
            'pendiente'       => 'Pendiente',
            'inicio_carga'    => 'Inicio de carga',
            'en_transito'     => 'En tránsito',
            'entregada'       => 'Entregada',
            'con_incidencia'  => 'Con incidencia',
            default           => ucfirst((string) $this->estado),
        };
    }

    public function getEstadoBadgeClassAttribute()
    {
        return match ($this->estado) {
            'pendiente'       => 'badge-warning',  // amarillo
            'inicio_carga'    => 'badge-info',     // celeste
            'en_transito'     => 'badge-primary',  // azul
            'entregada'       => 'badge-success',  // verde
            'con_incidencia'  => 'badge-danger',   // rojo
            default           => 'badge-secondary',
        };
    }

}
