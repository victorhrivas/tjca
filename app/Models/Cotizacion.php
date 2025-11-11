<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    public $table = 'cotizacions';

    public $fillable = [
        'solicitud_id',
        'estado',
        'monto',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'solicitud_id' => 'integer',
        'estado' => 'string',
        'monto' => 'integer'
    ];

    public static array $rules = [
        'solicitud_id' => 'required'
    ];

    public function solicitud()
    {
        return $this->belongsTo(\App\Models\Solicitud::class);
    }

        
}
