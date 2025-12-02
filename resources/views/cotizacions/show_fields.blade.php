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
</div>
