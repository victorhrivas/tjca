<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InicioCarga extends Model
{
    public $table = 'inicio_cargas';

    protected $fillable = [
        'ot_id',
        'ot_vehiculo_id',
        'cliente',
        'contacto',
        'telefono_contacto',
        'correo_contacto',
        'origen',
        'destino',
        'tipo_carga',
        // 'peso_aproximado',  // quitar
        'fecha_carga',
        'hora_presentacion',
        'conductor',
        'observaciones',
        'foto_1',
        'foto_2',
        'foto_3',
        'foto_guia_despacho', // nuevo
    ];
    
    protected $casts = [
        'ot_id'          => 'integer',
        'fecha_carga'    => 'date',
        'conforme'       => 'boolean',
        'ot_vehiculo_id' => 'integer',
    ];

    public static array $rules = [
        'ot_id'   => 'required|integer',
        'cliente' => 'required|string',
        'origen'  => 'required|string',
        'destino' => 'required|string',
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
        if (!$this->otVehiculo) return null;

        $label = $this->otVehiculo->patente_camion;

        if ($this->otVehiculo->patente_remolque) {
            $label .= ' · Rem: ' . $this->otVehiculo->patente_remolque;
        }

        if ($this->otVehiculo->conductor) {
            $label .= ' · ' . $this->otVehiculo->conductor;
        }

        return $label;
    }
}
