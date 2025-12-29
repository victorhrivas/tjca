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
        $fecha = $fecha instanceof Carbon ? $fecha : Carbon::parse($fecha);

        $periodo = $fecha->format('Ym'); // 202512

        // Bloquea la fila “más alta” del período mientras dure la transacción
        $ultimo = self::where('folio', 'like', $periodo . '/%')
            ->orderBy('folio', 'desc')
            ->lockForUpdate()
            ->first();

        $ultimoCorrelativo = 0;

        if ($ultimo && preg_match('#^' . $periodo . '/(\d+)$#', $ultimo->folio, $m)) {
            $ultimoCorrelativo = (int) $m[1];
        }

        $nuevo = $ultimoCorrelativo + 1;

        return sprintf('%s/%03d', $periodo, $nuevo);
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

    public function vehiculos()
    {
        return $this->hasMany(\App\Models\OtVehiculo::class, 'ot_id')->orderBy('orden');
    }

    public function vehiculoPrincipal()
    {
        return $this->hasOne(\App\Models\OtVehiculo::class, 'ot_id')->orderBy('orden');
    }

    public function getConductorAttribute($value)
    {
        $principal = $this->relationLoaded('vehiculoPrincipal')
            ? $this->getRelation('vehiculoPrincipal')
            : $this->vehiculoPrincipal()->first();

        return $principal?->conductor ?? $value;
    }

    public function getPatenteCamionAttribute($value)
    {
        $principal = $this->relationLoaded('vehiculoPrincipal')
            ? $this->getRelation('vehiculoPrincipal')
            : $this->vehiculoPrincipal()->first();

        return $principal?->patente_camion ?? $value;
    }

    public function getPatenteRemolqueAttribute($value)
    {
        $principal = $this->relationLoaded('vehiculoPrincipal')
            ? $this->getRelation('vehiculoPrincipal')
            : $this->vehiculoPrincipal()->first();

        return $principal?->patente_remolque ?? $value;
    }



}
