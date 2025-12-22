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
        'user_id'      => 'required|exists:users,id',
        'solicitante'  => 'required|string|max:255',
        'origen'       => 'required|string|max:255',
        'destino'      => 'required|string|max:255',
        'cliente'      => 'required|string|max:255',
        'estado'       => 'required|in:pendiente,enviada,aceptada,rechazada',

        'cargas'                   => 'required|array|min:1',
        'cargas.*.id'              => 'nullable|integer|exists:cotizacion_cargas,id',
        'cargas.*.descripcion'     => 'required|string|max:255',
        'cargas.*.cantidad'        => 'required|numeric|min:0.01',
        'cargas.*.precio_unitario' => 'required|integer|min:0',
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
            case 'pendiente':
                return 'badge-info'; // o 'badge-info' si te gusta más
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

    public function cargas()
    {
        return $this->hasMany(\App\Models\CotizacionCarga::class, 'cotizacion_id');
    }

    public function recalcularMonto(): void
    {
        $total = $this->cargas()->sum('subtotal');
        $this->update(['monto' => (int) $total]);
    }


}
