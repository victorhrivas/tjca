<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Cotizacion extends Model
{
    public $table = 'cotizacions';

    public $fillable = [
        'solicitud_id',
        'user_id',          // <--- NUEVO
        'solicitante',
        'estado',
        'monto',
        'origen',
        'destino',
        'cliente',
        'carga',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'solicitud_id' => 'integer',
        'user_id'      => 'integer',   // <--- NUEVO
        'solicitante'  => 'string',
        'estado'       => 'string',
        'monto'        => 'integer',
        'origen'       => 'string',
        'destino'      => 'string',
        'cliente'      => 'string',
        'carga'        => 'string',
    ];

    public static array $rules = [
        'solicitud_id' => 'required',
        'user_id'      => 'required|exists:users,id', // <--- NUEVO
        'origen'       => 'required',
        'destino'      => 'required',
        'cliente'      => 'required',
    ];

    public function solicitud()
    {
        return $this->belongsTo(\App\Models\Solicitud::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function ot()
    {
        return $this->hasOne(\App\Models\Ot::class);
    }


    // Badge según tus estados reales (enviada, aceptada, rechazada)
    public function getEstadoBadgeClassAttribute()
    {
        switch ($this->estado) {
            case 'aceptada':
                return 'badge-success';
            case 'rechazada':
                return 'badge-danger';
            case 'enviada':
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }

    public function getEstadoLabelAttribute()
    {
        return ucfirst($this->estado);
    }

    /**
     * Obtiene el objeto Cliente buscando en la tabla 'clientes' por el RUT
     * que está almacenado en el campo 'cliente' de esta cotización.
     * Acceso: $cotizacion->cliente_obj
     */
    public function getClienteObjAttribute()
    {
        // 1. Obtener el valor del campo 'cliente' (que contiene el RUT)
        $cliente = $this->cliente; 

        // 2. Consulta: Buscar el Cliente donde la columna 'rut' coincida con el valor.
        $cliente = Cliente::where('razon_social', $cliente)->first();

        // 3. Devolver el resultado.
        // Si la consulta no encuentra nada, $cliente será null.
        return $cliente;
    }
}
