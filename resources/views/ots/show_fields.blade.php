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

    {{-- =========================
         VEHÍCULOS / CHOFERES (N)
       ========================= --}}
    <div class="col-12">
        <hr>
        <h6 class="text-uppercase text-muted small mb-2">Vehículos / choferes asignados</h6>

        @php
            $vehiculos = $ot->vehiculos ?? collect();
        @endphp

        @if($vehiculos->count())
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-4">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 80px;">#</th>
                            <th>Conductor</th>
                            <th>Patente camión</th>
                            <th>Patente remolque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehiculos as $i => $v)
                            <tr>
                                <td><span class="badge badge-secondary">{{ $i + 1 }}</span></td>
                                <td>{{ $v->conductor ?: 'No asignado' }}</td>
                                <td>{{ $v->patente_camion ?: 'No registrada' }}</td>
                                <td>{{ $v->patente_remolque ?: 'No registrada' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Fallback legacy --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6 class="text-uppercase text-muted small mb-1">Conductor</h6>
                        <p class="mb-0 font-weight-bold">{{ $ot->conductor ?: 'No asignado' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <h6 class="text-uppercase text-muted small mb-1">Patente camión</h6>
                        <p class="mb-0">{{ $ot->patente_camion ?: 'No registrada' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <h6 class="text-uppercase text-muted small mb-1">Patente remolque</h6>
                        <p class="mb-0">{{ $ot->patente_remolque ?: 'No registrada' }}</p>
                    </div>
                </div>
            </div>
        @endif
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

    {{-- Montos --}}
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
            <p class="mb-0">{{ optional($ot->created_at)->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small mb-1">Última actualización</h6>
            <p class="mb-0">{{ optional($ot->updated_at)->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- IMÁGENES ASOCIADAS A LA OT --}}
{{-- ========================= --}}
<div class="row mt-4">

    {{-- INICIO DE CARGA --}}
    @if($ot->inicioCargas && $ot->inicioCargas->count())
        <div class="col-12 mb-3">
            <h5 class="text-uppercase text-muted small mb-2">Imágenes de inicio de carga</h5>
        </div>

        @foreach($ot->inicioCargas as $inicioCarga)
            @php
                $tieneFotos = $inicioCarga->foto_1 || $inicioCarga->foto_2 || $inicioCarga->foto_3;
            @endphp

            @if($tieneFotos)
                <div class="col-12 mb-2">
                    <small class="text-muted">
                        Inicio de carga #{{ $inicioCarga->id }}
                        @if($inicioCarga->created_at) · {{ $inicioCarga->created_at->format('d/m/Y H:i') }} @endif

                        @php
                            $vehiculoLabel = $inicioCarga->vehiculo_label;
                            if (!$vehiculoLabel && !empty($inicioCarga->conductor)) $vehiculoLabel = $inicioCarga->conductor;
                        @endphp

                        @if($vehiculoLabel)
                            · <span class="badge badge-dark">{{ $vehiculoLabel }}</span>
                        @else
                            · <span class="text-muted">Sin vehículo/chofer asociado</span>
                        @endif
                    </small>
                </div>

                @foreach (['foto_1', 'foto_2', 'foto_3'] as $foto)
                    @if(!empty($inicioCarga->$foto))
                        <div class="col-sm-6 col-md-3 mb-3">
                            <div class="card bg-dark border-0 shadow-sm h-100">
                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('storage/'.$inicioCarga->$foto) }}"
                                         alt="Foto inicio de carga"
                                         class="img-fluid rounded"
                                         style="max-height: 180px; object-fit: cover; cursor:pointer;"
                                         onclick="openImageOverlay('{{ asset('storage/'.$inicioCarga->$foto) }}')">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif

    {{-- Separador --}}
    @if(($ot->inicioCargas && $ot->inicioCargas->count()) && ($ot->entregas && $ot->entregas->count()))
        <div class="col-12 my-3"><hr></div>
    @endif

    {{-- ENTREGAS --}}
    @if($ot->entregas && $ot->entregas->count())
        <div class="col-12 mb-3">
            <h5 class="text-uppercase text-muted small mb-2">Imágenes de entrega de carga</h5>
        </div>

        @foreach($ot->entregas as $entrega)
            @php
                $tieneFotosEntrega = $entrega->foto_1 || $entrega->foto_2 || $entrega->foto_3;

                $guias = $entrega->guias ?? collect();          // NUEVO
                $tieneGuiaLegacy = !empty($entrega->foto_guia_despacho); // COMPAT
                $tieneGuiasEntrega = $guias->count() > 0 || $tieneGuiaLegacy;
            @endphp

            @if($tieneFotosEntrega || $tieneGuiasEntrega)
                <div class="col-12 mb-2">
                    <small class="text-muted">
                        Entrega #{{ $entrega->id }}
                        @if($entrega->fecha_entrega) · {{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }} @endif
                        @if($entrega->nombre_receptor) · Receptor: {{ $entrega->nombre_receptor }} @endif

                        @php
                            $vehiculoLabel = $entrega->vehiculo_label;
                            if (!$vehiculoLabel && !empty($entrega->conductor)) $vehiculoLabel = $entrega->conductor;
                        @endphp

                        @if($vehiculoLabel)
                            · <span class="badge badge-dark">{{ $vehiculoLabel }}</span>
                        @else
                            · <span class="text-muted">Sin vehículo/chofer asociado</span>
                        @endif
                    </small>
                </div>

                {{-- Fotos entrega --}}
                @foreach (['foto_1', 'foto_2', 'foto_3'] as $foto)
                    @if(!empty($entrega->$foto))
                        <div class="col-sm-6 col-md-3 mb-3">
                            <div class="card bg-dark border-0 shadow-sm h-100">
                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('storage/'.$entrega->$foto) }}"
                                         alt="Foto entrega"
                                         class="img-fluid rounded"
                                         style="max-height: 180px; object-fit: cover; cursor:pointer;"
                                         onclick="openImageOverlay('{{ asset('storage/'.$entrega->$foto) }}')">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                {{-- Guías de despacho (N) --}}
                @if($tieneGuiasEntrega)
                    <div class="col-12 mb-2">
                        <small class="text-muted">Guías de despacho (Entrega #{{ $entrega->id }})</small>
                    </div>

                    {{-- NUEVO: múltiples --}}
                    @if($guias->count() > 0)
                        @foreach($guias as $guia)
                            <div class="col-sm-6 col-md-3 mb-3">
                                <div class="card bg-dark border-0 shadow-sm h-100">
                                    <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('storage/'.$guia->archivo) }}"
                                             alt="Guía #{{ $guia->orden }}"
                                             class="img-fluid rounded"
                                             style="max-height: 180px; object-fit: cover; cursor:pointer;"
                                             onclick="openImageOverlay('{{ asset('storage/'.$guia->archivo) }}')">
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size:.82rem;">
                                    Guía #{{ $guia->orden }}
                                </small>
                            </div>
                        @endforeach
                    @else
                        {{-- COMPAT: entrega antigua --}}
                        <div class="col-sm-6 col-md-3 mb-3">
                            <div class="card bg-dark border-0 shadow-sm h-100">
                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('storage/'.$entrega->foto_guia_despacho) }}"
                                         alt="Guía de despacho"
                                         class="img-fluid rounded"
                                         style="max-height: 180px; object-fit: cover; cursor:pointer;"
                                         onclick="openImageOverlay('{{ asset('storage/'.$entrega->foto_guia_despacho) }}')">
                                </div>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size:.82rem;">
                                Guía #1
                            </small>
                        </div>
                    @endif
                @endif
            @endif
        @endforeach
    @endif

    {{-- Sin imágenes --}}
    @if(
        (!$ot->inicioCargas || !$ot->inicioCargas->count())
        && (!$ot->entregas || !$ot->entregas->count())
    )
        <div class="col-12">
            <span class="text-muted">Esta OT no tiene imágenes asociadas aún.</span>
        </div>
    @endif
</div>
