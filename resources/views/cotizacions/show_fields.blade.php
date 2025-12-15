<div class="row">
    {{-- Solicitud asociada --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Solicitud asociada</h6>
            <p class="mb-0 font-weight-bold">
                @if($cotizacion->solicitud)
                    <a href="{{ route('solicituds.show', $cotizacion->solicitud_id) }}">
                        Solicitud #{{ $cotizacion->solicitud_id }}
                    </a>
                @else
                    <span class="text-muted">Sin solicitud asociada</span>
                @endif
            </p>
        </div>
    </div>

    {{-- OT asociada (si existe relación) --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">OT asociada</h6>
            <p class="mb-0 font-weight-bold">
                @if($cotizacion->ot)
                    <a href="{{ route('ots.show', $cotizacion->ot->id) }}">
                        OT #{{ $cotizacion->ot->id }}
                    </a>
                @else
                    <span class="text-muted">Sin OT relacionada</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Monto --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Monto</h6>
            <p class="mb-0 h5">
                $ {{ number_format($cotizacion->monto, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Estado --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Estado</h6>
            <p class="mb-0">
                <span class="badge badge-pill {{ $cotizacion->estado_badge_class ?? 'badge-secondary' }} px-3 py-2">
                    {{ $cotizacion->estado_label ?? ucfirst($cotizacion->estado) }}
                </span>
            </p>
        </div>
    </div>

    {{-- Fechas --}}
    <div class="col-md-6">
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small mb-1">Creada</h6>
            <p class="mb-0">
                {{ optional($cotizacion->created_at)->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small mb-1">Última actualización</h6>
            <p class="mb-0">
                {{ optional($cotizacion->updated_at)->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- Cargas --}}
        <div class="col-12">
            <div class="mt-3">
                <h6 class="text-uppercase text-muted small mb-2">Cargas / Ítems</h6>

            @php
                $cargas = $cotizacion->cargas ?? collect();

                $items = $cargas->count()
                    ? $cargas
                    : collect([ (object)[
                        'descripcion'     => $cotizacion->carga ?? 'Servicio',
                        'cantidad'        => 1,
                        'precio_unitario' => (int)($cotizacion->monto ?? 0),
                        'subtotal'        => (int)($cotizacion->monto ?? 0),
                    ]]);

                $total = $items->sum('subtotal');
            @endphp


            @if($cargas->count())
                <div class="table-responsive">
                    <table class="table table-sm table-dark mb-0">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th class="text-right" style="width:140px;">Cantidad</th>
                                <th class="text-right" style="width:180px;">Precio unitario</th>
                                <th class="text-right" style="width:180px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $item->descripcion }}</td>
                                <td class="text-center">{{ number_format($item->cantidad, 2, ',', '.') }}</td>
                                <td class="text-right">$ {{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                                <td class="text-right">$ {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th class="text-right">$ {{ number_format((int)$cotizacion->monto, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Sin cargas registradas.</p>
            @endif
        </div>
    </div>
</div>
