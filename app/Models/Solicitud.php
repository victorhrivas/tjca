<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public $table = 'solicituds';

    public $fillable = [
        'cliente_id',
        'solicitante',
        'canal',
        'origen',
        'destino',
        'carga',
        'valor',
        'notas',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'cliente_id' => 'integer',
        'solicitante' => 'string',
        'canal'      => 'string',
        'origen'     => 'string',
        'destino'    => 'string',
        'carga'      => 'string',
        'notas'      => 'string',
        'estado' => 'string'
    ];

    public static array $rules = [
        'cliente_id'           => 'required',
        'origen'               => 'required',
        'destino'              => 'required',

        'cargas'                       => 'required|array|min:1',
        'cargas.*.id'                  => 'nullable|integer|exists:solicitud_cargas,id',
        'cargas.*.descripcion'         => 'required|string|max:255',
        'cargas.*.cantidad'            => 'required|numeric|min:0.01',
        'cargas.*.precio_unitario'     => 'required|integer|min:0',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($solicitud) {
            if (empty($solicitud->notas)) {
                $solicitud->notas = 'Sin información adicional';
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class);
    }

    public function cotizacion()
    {
        return $this->hasOne(\App\Models\Cotizacion::class);
    }

    public function cargas()
    {
        return $this->hasMany(\App\Models\SolicitudCarga::class, 'solicitud_id');
    }

}
