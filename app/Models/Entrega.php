<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    public $table = 'entregas';

    protected $fillable = [
        'ot_id',
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
    ];

    public static array $rules = [
        'ot_id'           => 'required',
        'nombre_receptor' => 'required',
    ];

    public function ot()
    {
        return $this->belongsTo(\App\Models\Ot::class);
    }
}
