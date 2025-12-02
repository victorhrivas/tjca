<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InicioCarga extends Model
{
    public $table = 'inicio_cargas';

    protected $fillable = [
        'ot_id',
        'cliente',
        'contacto',
        'telefono_contacto',
        'correo_contacto',
        'origen',
        'destino',
        'tipo_carga',
        'peso_aproximado',
        'fecha_carga',
        'hora_presentacion',
        'conductor',
        'observaciones',
    ];

    protected $casts = [
        'ot_id'          => 'integer',
        'fecha_carga'    => 'date',
        'conforme'       => 'boolean',
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
}
