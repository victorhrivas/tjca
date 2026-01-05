<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    public $table = 'entregas';

    protected $fillable = [
        'ot_id',
        'ot_vehiculo_id',
        'cliente',
        'nombre_receptor',
        'rut_receptor',
        'telefono_receptor',
        'correo_receptor',
        'lugar_entrega',
        'fecha_entrega',
        'hora_entrega',
        'numero_guia',
        'numero_interno',
        'conforme',
        'conductor',
        'observaciones',
        'foto_1',
        'foto_2',
        'foto_3',
        'foto_guia_despacho', // <-- agregar
    ];

    protected $casts = [
        'ot_id'             => 'integer',
        'fecha_entrega'     => 'date',
        'conforme'          => 'boolean',
        'ot_vehiculo_id' => 'integer',
    ];

    public static array $rules = [
        'ot_id'           => 'required',
        'nombre_receptor' => 'required',
    ];

    public function ot()
    {
        return $this->belongsTo(\App\Models\Ot::class);
    }

    public function otVehiculo()
    {
        return $this->belongsTo(\App\Models\OtVehiculo::class, 'ot_vehiculo_id');
    }

    public function getVehiculoLabelAttribute()
    {
        $v = $this->otVehiculo;
        if (!$v) return null;

        $label = trim((string) $v->patente_camion);

        if (!empty($v->patente_remolque)) {
            $label .= ' · Rem: ' . $v->patente_remolque;
        }

        if (!empty($v->conductor)) {
            $label .= ' · ' . $v->conductor;
        }

        return $label ?: null;
    }

}
