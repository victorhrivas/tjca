<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Ot extends Model
{
    public $table = 'ots';

    protected $fillable = [
        'cotizacion_id',
        'equipo',
        'origen',
        'destino',
        'cliente',
        'valor',
        'fecha',
        'solicitante',
        'conductor',

        // ORIGEN
        'contacto_origen',
        'telefono_origen',
        'direccion_origen',
        'link_mapa_origen',

        // DESTINO
        'contacto_destino',
        'telefono_destino',
        'direccion_destino',
        'link_mapa_destino',

        // Campo legacy (si lo sigues usando en alguna parte)
        'link_mapa',

        'patente_camion',
        'patente_remolque',
        'estado',
        'observaciones',
        'folio',
    ];

    protected $casts = [
        'cotizacion_id'    => 'integer',
        'conductor'        => 'string',
        'contacto_origen'  => 'string',
        'contacto_destino' => 'string',
        'link_mapa' => 'string',
        'patente_camion'   => 'string',
        'patente_remolque' => 'string',
        'estado'           => 'string',
    ];

    public static array $rules = [
        'cotizacion_id' => 'required',
    ];



    /**
     * Genera un folio para una fecha dada.
     * Formato: AAAAMM/NNN (ej: 202512/001).
     */
    public static function generarFolioParaFecha(Carbon $fecha): string
    {
        if (! $fecha instanceof Carbon) {
            $fecha = Carbon::parse($fecha);
        }

        // Prefijo del período: 202512
        $periodo = $fecha->format('Ym');

        // Contar cuántas OTs ya tienen folio en ese período
        // Ej: todos los que empiezan con "202512/"
        $cantidadMes = self::where('folio', 'like', $periodo . '/%')->count() + 1;

        // 001, 002, 003...
        $correlativo = str_pad($cantidadMes, 3, '0', STR_PAD_LEFT);

        return "{$periodo}/{$correlativo}";
    }

    public function cotizacion()
    {
        return $this->belongsTo(\App\Models\Cotizacion::class);
    }

    public function getEstadoLabelAttribute()
    {
        return match ($this->estado) {
            'pendiente'       => 'Pendiente',
            'inicio_carga'    => 'Inicio de carga',
            'en_transito'     => 'En tránsito',
            'entregada'       => 'Entregada',
            'con_incidencia'  => 'Con incidencia',
            default           => ucfirst((string) $this->estado),
        };
    }

    public function getEstadoBadgeClassAttribute()
    {
        return match ($this->estado) {
            'pendiente'       => 'badge-warning',  // amarillo
            'inicio_carga'    => 'badge-info',     // celeste
            'en_transito'     => 'badge-primary',  // azul
            'entregada'       => 'badge-success',  // verde
            'con_incidencia'  => 'badge-danger',   // rojo
            default           => 'badge-secondary',
        };
    }

    public function inicioCargas()
    {
        return $this->hasMany(\App\Models\InicioCarga::class, 'ot_id');
    }

    public function entregas()
    {
        return $this->hasMany(\App\Models\Entrega::class, 'ot_id');
    }

}
