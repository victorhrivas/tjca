<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DashboardOtExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'OT',
            'Equipo',
            'Traslado',
            'Estado',
            'Desde',
            'Hasta',
            'Cliente',
            'Valor',
            'Costo EXT',
            'Cotización',
            'Fecha inicio carga',
            'Solicitante',
            'Conductor',
            'OC',
            'Estado OC',
            'GDD',
            'AF/ID interno',
            'Factura EXT',
            'Factura',
            'Fecha Factura',
        ];
    }

    public function map($ot): array
    {
        $cotizacion = $ot->cotizacion;

        $clienteNombre = $cotizacion->cliente
            ?? optional(optional(optional($cotizacion)->solicitud)->cliente)->razon_social
            ?? '-';

        $fechaInicioCarga = optional($ot->inicioCargas->sortBy('created_at')->first())->created_at
            ?? optional($ot->inicioCargas->sortBy('fecha')->first())->fecha
            ?? null;

        return [
            $ot->folio ?: '#' . $ot->id,
            $ot->equipo ?? '-',
            $ot->traslado ?? '-',
            $ot->estado_label ?? ($ot->estado ? ucfirst(str_replace('_', ' ', $ot->estado)) : '-'),
            optional($cotizacion)->origen ?? '-',
            optional($cotizacion)->destino ?? '-',
            $clienteNombre,
            is_null($ot->valor) ? null : (int) $ot->valor,
            is_null($ot->costo_ext) ? null : (int) $ot->costo_ext,
            optional($cotizacion)->id ?? null,
            $fechaInicioCarga ? Carbon::parse($fechaInicioCarga)->format('d/m/Y') : '-',
            $ot->solicitante ?? optional($cotizacion)->solicitante ?? '-',
            $ot->conductor ?? '-',
            $ot->oc ?? '-',
            $ot->status ?? '-',
            $ot->gdd ?? '-',
            $ot->afid_interno ?? '-',
            $ot->factura_externo ?? '-',
            $ot->factura ?? '-',
            $ot->fecha_factura ? Carbon::parse($ot->fecha_factura)->format('d/m/Y') : '-',
        ];
    }
}