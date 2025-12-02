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
        'updated_at',
    ];

    protected $casts = [
        'cotizacion_id'    => 'integer',
        'conductor'        => 'string',
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

    // Colores según estado típico: inicio_carga, en_transito, entregada
    public function getEstadoBadgeClassAttribute()
    {
        switch ($this->estado) {
            case 'entregada':
                return 'badge-success';
            case 'en_transito':
                return 'badge-warning';
            case 'inicio_carga':
                return 'badge-info';
            default:
                return 'badge-secondary';
        }
    }

    public function getEstadoLabelAttribute()
    {
        // Reemplaza guiones bajos por espacio y capitaliza
        return ucwords(str_replace('_', ' ', $this->estado));
    }
}
