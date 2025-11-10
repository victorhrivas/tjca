<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public $table = 'solicituds';

    public $fillable = [
        'cliente_id',
        'canal',
        'origen',
        'destino',
        'carga',
        'notas',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'cliente_id' => 'integer',
        'canal' => 'string',
        'origen' => 'string',
        'destino' => 'string',
        'carga' => 'string',
        'notas' => 'string'
    ];

    public static array $rules = [
        'cliente_id' => 'required',
        'origen' => 'required',
        'destino' => 'required'
    ];

    
}
