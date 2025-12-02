<div class="row">
    {{-- Cotización asociada --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Cotización asociada</h6>
            <p class="mb-0 font-weight-bold">
                @if($ot->cotizacion)
                    <a href="{{ route('cotizacions.show', $ot->cotizacion->id) }}">
                        Cotización #{{ $ot->cotizacion->id }}
                    </a>
                @else
                    <span class="text-muted">Sin cotización asociada</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Cliente de la cotización (si existe) --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Cliente</h6>
            <p class="mb-0">
                @if($ot->cotizacion && $ot->cotizacion->cliente)
                    {{ $ot->cotizacion->cliente }}
                @else
                    <span class="text-muted">Sin información de cliente</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Origen / Destino desde cotización --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Origen</h6>
            <p class="mb-0">
                @if($ot->cotizacion && $ot->cotizacion->origen)
                    {{ $ot->cotizacion->origen }}
                @else
                    <span class="text-muted">No especificado</span>
                @endif
            </p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Destino</h6>
            <p class="mb-0">
                @if($ot->cotizacion && $ot->cotizacion->destino)
                    {{ $ot->cotizacion->destino }}
                @else
                    <span class="text-muted">No especificado</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Conductor --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Conductor</h6>
            <p class="mb-0 font-weight-bold">
                {{ $ot->conductor ?: 'No asignado' }}
            </p>
        </div>
    </div>

    {{-- Patentes --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Patente camión</h6>
            <p class="mb-0">
                {{ $ot->patente_camion ?: 'No registrada' }}
            </p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Patente remolque</h6>
            <p class="mb-0">
                {{ $ot->patente_remolque ?: 'No registrada' }}
            </p>
        </div>
    </div>

    {{-- Estado --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Estado</h6>
            <p class="mb-0">
                <span class="badge badge-pill {{ $ot->estado_badge_class ?? 'badge-secondary' }} px-3 py-2">
                    {{ $ot->estado_label ?? ucwords(str_replace('_',' ',$ot->estado)) }}
                </span>
            </p>
        </div>
    </div>

    {{-- Montos desde cotización (si quieres mostrar) --}}
    <div class="col-md-6">
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small mb-1">Valor servicio</h6>
            <p class="mb-0">
                @if($ot->cotizacion && $ot->cotizacion->monto)
                    $ {{ number_format($ot->cotizacion->monto, 0, ',', '.') }} CLP
                @else
                    <span class="text-muted">No definido</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Fechas --}}
    <div class="col-md-6">
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small mb-1">Creada</h6>
            <p class="mb-0">
                {{ optional($ot->created_at)->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small mb-1">Última actualización</h6>
            <p class="mb-0">
                {{ optional($ot->updated_at)->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>
</div>
