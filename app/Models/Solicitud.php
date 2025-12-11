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
        'cliente_id' => 'required',
        'origen'     => 'required',
        'destino'    => 'required'
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
}
