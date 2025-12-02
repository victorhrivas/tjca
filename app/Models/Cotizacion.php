<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    public $table = 'cotizacions';

    public $fillable = [
        'solicitud_id',
        'solicitante',
        'estado',
        'monto',
        'origen',
        'destino',
        'cliente',
        'carga',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'solicitud_id' => 'integer',
        'solicitante'  => 'string',
        'estado'       => 'string',
        'monto'        => 'integer',
        'origen'       => 'string',
        'destino'      => 'string',
        'cliente'      => 'string',
        'carga'        => 'string',
    ];

    public static array $rules = [
        'solicitud_id' => 'required',
        'origen'       => 'required',
        'destino'      => 'required',
        'cliente'      => 'required',
    ];

    public function solicitud()
    {
        return $this->belongsTo(\App\Models\Solicitud::class);
    }

    public function ot()
    {
        return $this->hasOne(\App\Models\Ot::class);
    }

    // Badge según tus estados reales (enviada, aceptada, rechazada)
    public function getEstadoBadgeClassAttribute()
    {
        switch ($this->estado) {
            case 'aceptada':
                return 'badge-success';
            case 'rechazada':
                return 'badge-danger';
            case 'enviada':
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }

    public function getEstadoLabelAttribute()
    {
        return ucfirst($this->estado);
    }
}
