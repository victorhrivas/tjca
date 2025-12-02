<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    public $table = 'entregas';

    public $fillable = [
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
        'conductor',       // NUEVO
        'observaciones',
        'fotos',
    ];

    protected $casts = [
        'ot_id'            => 'integer',
        'nombre_receptor'  => 'string',
        'cliente'          => 'string',
        'rut_receptor'     => 'string',
        'telefono_receptor'=> 'string',
        'correo_receptor'  => 'string',
        'lugar_entrega'    => 'string',
        'fecha_entrega'    => 'date',
        'hora_entrega'     => 'string',
        'numero_guia'      => 'string',
        'numero_interno'   => 'string',
        'conforme'         => 'boolean',
        'conductor'        => 'string',
        'observaciones'    => 'string',
        'fotos'            => 'string',
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
