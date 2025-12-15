@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    {{-- Título --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="mb-0">Dashboard general – Mes en curso</h3>
            <small class="text-muted">
                Resumen ejecutivo entre {{ $inicioMes->format('d-m-Y') }} y {{ $finMes->format('d-m-Y') }}.
            </small>
        </div>
    </div>

    {{-- KPIs principales --}}
    <div class="row">
        {{-- Solicitudes --}}
        <div class="col-md-2 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Solicitudes</span>
                        <span data-toggle="tooltip"
                              title="Cantidad de solicitudes creadas en el mes en curso.">
                            <i class="fas fa-question-circle text-muted"></i>
                        </span>
                    </div>
                    <h4 class="mt-2 mb-0">{{ number_format($totales['solicitudes'] ?? 0) }}</h4>
                </div>
            </div>
        </div>

        {{-- Cotizaciones --}}
        <div class="col-md-2 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Cotizaciones</span>
                        <span data-toggle="tooltip"
                              title="Número total de cotizaciones creadas este mes, con su monto acumulado.">
                            <i class="fas fa-question-circle text-muted"></i>
                        </span>
                    </div>
                    <h4 class="mt-2 mb-0">{{ number_format($totales['cotizaciones'] ?? 0) }}</h4>
                    <small class="text-muted">
                        Monto mes: ${{ number_format($montoCotizadoMes ?? 0, 0, ',', '.') }}
                    </small>
                </div>
            </div>
        </div>

        {{-- OT (mes) + OT en curso (todas las fechas) --}}
        <div class="col-md-2 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Órdenes de Trabajo (mes)</span>
                        <span data-toggle="tooltip"
                              title="Cantidad de OT creadas en el mes en curso. Debajo se muestra cuántas OT están en curso considerando todas las fechas.">
                            <i class="fas fa-question-circle text-muted"></i>
                        </span>
                    </div>
                    <h4 class="mt-2 mb-0">{{ number_format($totales['ots'] ?? 0) }}</h4>
                    <small class="text-muted">
                        En curso (todas las fechas): {{ number_format($otsEnCursoTotal ?? 0) }}
                    </small>

                    <small class="text-muted d-block">
                        Monto OT en tránsito (mes): ${{ number_format($montoOtsEnTransitoMes ?? 0, 0, ',', '.') }}
                    </small>

                </div>
            </div>
        </div>

        {{-- Inicios de carga --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Inicios de carga</span>
                        <span data-toggle="tooltip"
                              title="Cantidad de inicios de carga registrados en el mes, asociados a OT.">
                            <i class="fas fa-question-circle text-muted"></i>
                        </span>
                    </div>
                    <h4 class="mt-2 mb-0">{{ number_format($totales['inicios_carga'] ?? 0) }}</h4>
                </div>
            </div>
        </div>

        {{-- Entregas --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Entregas</span>
                        <span data-toggle="tooltip"
                              title="Cantidad de entregas registradas en el mes en curso.">
                            <i class="fas fa-question-circle text-muted"></i>
                        </span>
                    </div>
                    <h4 class="mt-2 mb-0">{{ number_format($totales['entregas'] ?? 0) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- OT en curso (focus principal) --}}
    <div class="row mt-3">
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-3);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <div>
                        <strong>Órdenes de Trabajo en curso</strong>
                        <small class="text-muted d-block">
                            Cualquier fecha • Estados distintos de <code>entregada</code> • Ordenadas de más antigua a más reciente.
                        </small>
                    </div>
                    <span data-toggle="tooltip"
                          title="Se muestran las OT que todavía no están entregadas (estado distinto de 'entregada'), sin importar la fecha. Se ordenan de la más antigua a la más reciente para ver primero las que llevan más tiempo abiertas.">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th>Fecha OT</th>
                                <th>Cliente</th>
                                <th>Conductor</th>
                                <th>Estado</th>
                                <th class="text-right">Días en curso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($otsEnCursoListado as $ot)
                                @php
                                    $clienteNombre = optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social
                                        ?? '-';

                                    $badgeClass = match($ot->estado) {
                                        'pendiente'      => 'badge-warning',
                                        'inicio_carga'   => 'badge-info',
                                        'en_transito'    => 'badge-primary',
                                        'con_incidencia' => 'badge-danger',
                                        default          => 'badge-secondary'
                                    };

                                    $diasEnCurso = $ot->created_at
                                        ? $ot->created_at->diffInDays($hoy)
                                        : null;
                                @endphp
                                <tr>
                                    <td>{{ optional($ot->created_at)->format('d-m-Y H:i') }}</td>
                                    <td>{{ $clienteNombre }}</td>
                                    <td>{{ $ot->conductor ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $ot->estado_label ?? ucfirst(str_replace('_',' ',$ot->estado)) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        @if(!is_null($diasEnCurso))
                                            {{ $diasEnCurso }} {{ \Illuminate\Support\Str::plural('día', $diasEnCurso) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted text-center py-3">
                                        No hay Órdenes de Trabajo en curso. Todas están entregadas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(($otsEnCursoTotal ?? 0) > ($otsEnCursoListado->count() ?? 0))
                    <div class="card-footer text-right">
                        <small class="text-muted">
                            Mostrando {{ $otsEnCursoListado->count() }} de {{ $otsEnCursoTotal }} OT en curso.
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Funnel + gráfico --}}
    <div class="row mt-3">
        {{-- Funnel cotizaciones --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <strong>Cotizaciones por estado (mes)</strong>
                    <span data-toggle="tooltip"
                          title="Distribución de las cotizaciones del mes según su estado (enviada, aceptada, rechazada, etc.).">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>
                <div class="card-body p-3">
                    @if($cotizacionesPorEstado->count())
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr class="text-muted">
                                    <th>Estado</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacionesPorEstado as $row)
                                    <tr>
                                        <td>{{ ucfirst($row->estado ?? 'Sin estado') }}</td>
                                        <td class="text-right">{{ number_format($row->total ?? 0) }}</td>
                                        <td class="text-right">
                                            ${{ number_format($row->monto_total ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">No hay cotizaciones registradas este mes.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Funnel OT mes --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <strong>Órdenes de Trabajo por estado (mes)</strong>
                    <span data-toggle="tooltip"
                          title="Cantidad de OT del mes agrupadas por su estado operativo.">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>
                <div class="card-body p-3">
                    @if($otsPorEstado->count())
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr class="text-muted">
                                    <th>Estado</th>
                                    <th class="text-right">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($otsPorEstado as $row)
                                    @php
                                        $badgeClass = match($row->estado) {
                                            'pendiente'      => 'badge-warning',
                                            'inicio_carga'   => 'badge-info',
                                            'en_transito'    => 'badge-primary',
                                            'entregada'      => 'badge-success',
                                            'con_incidencia' => 'badge-danger',
                                            default          => 'badge-secondary'
                                        };
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $row->estado ?? '')) }}
                                            </span>
                                        </td>
                                        <td class="text-right">{{ number_format($row->total ?? 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">No hay OT registradas este mes.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Gráfico cotizaciones mes --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100" style="background:var(--bg-2);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <strong>Evolución cotizaciones (mes)</strong>
                    <span data-toggle="tooltip"
                          title="Cantidad y monto diario de cotizaciones generadas en el mes en curso.">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>
                <div class="card-body p-3">
                    @if(!empty($chartCotizaciones['labels']))
                        <canvas id="cotizacionesChart" height="160"></canvas>
                    @else
                        <p class="text-muted mb-0">Aún no hay datos suficientes para graficar este mes.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Actividad reciente por módulo --}}
    <div class="row mt-3">
        {{-- Cotizaciones recientes --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-3);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <strong>Cotizaciones recientes (mes)</strong>
                    <span data-toggle="tooltip"
                          title="Últimas cotizaciones creadas en el mes, con su cliente y estado.">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th class="text-right">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCotizaciones as $c)
                                <tr>
                                    <td>{{ optional($c->created_at)->format('d-m H:i') }}</td>
                                    <td>
                                        {{ $c->cliente ?? optional(optional($c->solicitud)->cliente)->razon_social ?? '-' }}
                                    </td>
                                    <td class="text-right">
                                        <span class="badge {{ $c->estado_badge_class ?? 'badge-secondary' }}">
                                            {{ $c->estado_label ?? ucfirst($c->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">
                                        No hay cotizaciones registradas este mes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- OT recientes --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-3);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <strong>Órdenes de Trabajo recientes (mes)</strong>
                    <span data-toggle="tooltip"
                          title="Últimas OT creadas en el mes, indicando el cliente asociado y su estado.">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th class="text-right">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOts as $ot)
                                <tr>
                                    <td>{{ optional($ot->created_at)->format('d-m H:i') }}</td>
                                    <td>
                                        {{ optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social ?? '-' }}
                                    </td>
                                    <td class="text-right">
                                        <span class="badge {{ $ot->estado_badge_class ?? 'badge-secondary' }}">
                                            {{ $ot->estado_label ?? ucfirst($ot->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">
                                        No hay OT registradas este mes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Entregas recientes --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm" style="background:var(--bg-3);border-color:var(--line);">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center"
                     style="border-color:var(--line);">
                    <strong>Entregas recientes (mes)</strong>
                    <span data-toggle="tooltip"
                          title="Últimas entregas registradas en el mes, indicando cliente y si quedó conforme.">
                        <i class="fas fa-question-circle text-muted"></i>
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th class="text-right">Conforme</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEntregas as $ent)
                                <tr>
                                    <td>{{ optional($ent->created_at)->format('d-m H:i') }}</td>
                                    <td>
                                        {{ $ent->cliente
                                            ?? optional(optional(optional($ent->ot)->cotizacion)->solicitud)->cliente->razon_social
                                            ?? '-' }}
                                    </td>
                                    <td class="text-right">
                                        @if($ent->conforme)
                                            <span class="badge badge-success">Sí</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">
                                        No hay entregas registradas este mes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Tooltips Bootstrap
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Gráfico de cotizaciones del mes
        @if(!empty($chartCotizaciones['labels']))
        const ctx = document.getElementById('cotizacionesChart').getContext('2d');
        const dataCotizaciones = @json($chartCotizaciones);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dataCotizaciones.labels,
                datasets: [
                    {
                        label: 'Cantidad',
                        data: dataCotizaciones.totales,
                        borderWidth: 2,
                        fill: false,
                        tension: 0.2
                    },
                    {
                        label: 'Monto',
                        data: dataCotizaciones.montos,
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#e6e7ea'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#a7adb7' },
                        grid: { display: false }
                    },
                    y: {
                        position: 'left',
                        ticks: { color: '#a7adb7' },
                        grid: { color: '#2c3139' }
                    },
                    y1: {
                        position: 'right',
                        ticks: { color: '#a7adb7' },
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });
        @endif
    </script>
@endsection
