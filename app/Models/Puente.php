<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puente extends Model
{
    public $table = 'puentes';

    public $fillable = [
        'ot_id',
        'fase',
        'motivo',
        'detalle',
        'notificar_cliente',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'ot_id' => 'integer',
        'fase' => 'string',
        'motivo' => 'string',
        'detalle' => 'string',
        'notificar_cliente' => 'boolean'
    ];

    public static array $rules = [
        'ot_id' => 'required',
        'fase' => 'required',
        'motivo' => 'required'
    ];

    
}
