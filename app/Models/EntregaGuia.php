<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaGuia extends Model
{
    protected $table = 'entrega_guias';

    protected $fillable = [
        'entrega_id',
        'archivo',
        'orden',
    ];

    protected $casts = [
        'entrega_id' => 'integer',
        'orden' => 'integer',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
