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

{{-- ========================= --}}
{{-- IMÁGENES ASOCIADAS A LA OT --}}
{{-- ========================= --}}
<div class="row mt-4">

    {{-- Imágenes de INICIO DE CARGA --}}
    @if($ot->inicioCargas && $ot->inicioCargas->count())
        <div class="col-12 mb-3">
            <h5 class="text-uppercase text-muted small mb-2">
                Imágenes de inicio de carga
            </h5>
        </div>

        @foreach($ot->inicioCargas as $inicioCarga)
            @php
                $tieneFotos = $inicioCarga->foto_1 || $inicioCarga->foto_2 || $inicioCarga->foto_3;
                $tieneGuia  = !empty($inicioCarga->foto_guia_despacho);
            @endphp

            @if($tieneFotos || $tieneGuia)
                <div class="col-12 mb-2">
                    <small class="text-muted">
                        Inicio de carga #{{ $inicioCarga->id }}
                        @if($inicioCarga->created_at)
                            · {{ $inicioCarga->created_at->format('d/m/Y H:i') }}
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

                @if($tieneGuia)
                    <div class="col-12 mb-2">
                        <small class="text-muted">
                            Guía de despacho (Inicio de carga #{{ $inicioCarga->id }})
                        </small>
                    </div>

                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card bg-dark border-0 shadow-sm h-100">
                            <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('storage/'.$inicioCarga->foto_guia_despacho) }}"
                                    alt="Guía de despacho"
                                    class="img-fluid rounded"
                                    style="max-height: 180px; object-fit: cover; cursor:pointer;"
                                    onclick="openImageOverlay('{{ asset('storage/'.$inicioCarga->foto_guia_despacho) }}')">
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @endif

    {{-- Separador si hay ambos tipos --}}
    @if(($ot->inicioCargas && $ot->inicioCargas->count()) && ($ot->entregas && $ot->entregas->count()))
        <div class="col-12 my-3">
            <hr>
        </div>
    @endif

    {{-- Imágenes de ENTREGA --}}
    @if($ot->entregas && $ot->entregas->count())
        <div class="col-12 mb-3">
            <h5 class="text-uppercase text-muted small mb-2">
                Imágenes de entrega de carga
            </h5>
        </div>

        @foreach($ot->entregas as $entrega)
            @php
                $tieneFotosEntrega = $entrega->foto_1 || $entrega->foto_2 || $entrega->foto_3;
            @endphp

            @if($tieneFotosEntrega)
                <div class="col-12 mb-2">
                    <small class="text-muted">
                        Entrega #{{ $entrega->id }}
                        @if($entrega->fecha_entrega)
                            · {{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }}
                        @endif
                        @if($entrega->nombre_receptor)
                            · Receptor: {{ $entrega->nombre_receptor }}
                        @endif
                    </small>
                </div>

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
            @endif
        @endforeach
    @endif

    @if(
        (!$ot->inicioCargas || !$ot->inicioCargas->count())
        && (!$ot->entregas || !$ot->entregas->count())
    )
        <div class="col-12">
            <span class="text-muted">Esta OT no tiene imágenes asociadas aún.</span>
        </div>
    @endif
</div>

