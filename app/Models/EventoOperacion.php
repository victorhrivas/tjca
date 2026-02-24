<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoOperacion extends Model
{
    public $table = 'evento_operacions';

    public $fillable = [
        'ot_id',
        'tipo',
        'observaciones',
        'fotos',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'ot_id' => 'integer',
        'tipo' => 'string',
        'observaciones' => 'string'
    ];

    public static array $rules = [
        'ot_id' => 'required',
        'tipo' => 'required'
    ];

    
}
