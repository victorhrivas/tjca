<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtVehiculo extends Model
{
    protected $table = 'ot_vehiculos';

    protected $fillable = [
        'ot_id',
        'conductor',
        'patente_camion',
        'patente_remolque',
        'orden',
        'rol',
        'observaciones',
        'desde',
        'hasta',
    ];

    protected $casts = [
        'ot_id' => 'integer',
        'orden' => 'integer',
        'desde' => 'datetime',
        'hasta' => 'datetime',
    ];

    public function ot()
    {
        return $this->belongsTo(\App\Models\Ot::class, 'ot_id');
    }
}
