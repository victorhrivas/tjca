{{-- resources/views/ots/fields.blade.php --}}

<!-- Cotización Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cotizacion_id', 'Cotización (ID):') !!}
    {!! Form::number('cotizacion_id', null, [
        'class' => 'form-control',
        'required' => true,
        'min' => 1
    ]) !!}
</div>

<!-- Equipo / Tipo de carga -->
<div class="form-group col-sm-6">
    {!! Form::label('equipo', 'Equipo / Tipo de carga:') !!}
    {!! Form::text('equipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Origen -->
<div class="form-group col-sm-6">
    {!! Form::label('origen', 'Origen (dirección / faena):') !!}
    {!! Form::text('origen', null, ['class' => 'form-control']) !!}
</div>

<!-- Destino -->
<div class="form-group col-sm-6">
    {!! Form::label('destino', 'Destino (dirección / faena):') !!}
    {!! Form::text('destino', null, ['class' => 'form-control']) !!}
</div>

<!-- Cliente -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente', 'Cliente:') !!}
    {!! Form::text('cliente', null, ['class' => 'form-control']) !!}
</div>

<!-- Valor -->
<div class="form-group col-sm-6">
    {!! Form::label('valor', 'Valor (CLP):') !!}
    {!! Form::number('valor', null, [
        'class' => 'form-control',
        'min' => 0,
        'step' => 1
    ]) !!}
</div>

<!-- Fecha -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha de servicio:') !!}
    {!! Form::date('fecha', isset($ot) && $ot->fecha ? $ot->fecha : null, [
        'class' => 'form-control'
    ]) !!}
</div>

<!-- Solicitante -->
<div class="form-group col-sm-6">
    {!! Form::label('solicitante', 'Solicitante:') !!}
    {!! Form::text('solicitante', null, ['class' => 'form-control']) !!}
</div>

{{-- =========================
     VEHÍCULOS / CHOFERES (N)
   ========================= --}}
<div class="col-12">
    <hr>
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Vehículos / choferes</h5>

        <button type="button" class="btn btn-sm btn-primary" id="btnAddVehiculo">
            + Agregar vehículo
        </button>
    </div>
    <small class="text-muted d-block mt-2">
        Puedes agregar más de un vehículo/chofer para la misma OT. El primero será el “principal”.
    </small>
</div>

@php
    /**
     * Pre-carga:
     * - En CREATE: usa old('vehiculos') o 1 fila vacía
     * - En EDIT: si existe $ot y tiene vehiculos, usa esos; si no, fallback a los campos legacy
     */
    $vehiculos = [];

    if (old('vehiculos')) {
        $vehiculos = old('vehiculos');
    } elseif (isset($ot)) {
        // Si ya cargaste relación en controller: $ot->load('vehiculos')
        if (isset($ot->vehiculos) && $ot->vehiculos->count() > 0) {
            $vehiculos = $ot->vehiculos->map(function ($v) {
                return [
                    'conductor' => $v->conductor,
                    'patente_camion' => $v->patente_camion,
                    'patente_remolque' => $v->patente_remolque,
                ];
            })->toArray();
        } else {
            // Fallback a legacy
            $vehiculos = [[
                'conductor' => $ot->conductor ?? null,
                'patente_camion' => $ot->patente_camion ?? null,
                'patente_remolque' => $ot->patente_remolque ?? null,
            ]];
        }
    } else {
        $vehiculos = [[
            'conductor' => null,
            'patente_camion' => null,
            'patente_remolque' => null,
        ]];
    }
@endphp

<div class="col-12 mt-3" id="vehiculosWrapper">
    @foreach($vehiculos as $i => $v)
        <div class="card mb-3 vehiculo-item" data-index="{{ $i }}">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <strong>Vehículo #{{ $i + 1 }}</strong>
                    @if($i === 0)
                        <span class="badge badge-secondary ml-2">Principal</span>
                    @endif
                </div>

                <button type="button"
                        class="btn btn-sm btn-danger btnRemoveVehiculo"
                        @if($i === 0 && count($vehiculos) === 1) style="display:none" @endif>
                    Quitar
                </button>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Conductor -->
                    <div class="form-group col-sm-4">
                        {!! Form::label("vehiculos[$i][conductor]", 'Conductor:') !!}
                        {!! Form::select("vehiculos[$i][conductor]", $conductores, $v['conductor'] ?? null, [
                            'class' => 'form-control',
                            'placeholder' => 'Seleccione un conductor'
                        ]) !!}
                    </div>

                    <!-- Patente camión -->
                    <div class="form-group col-sm-4">
                        {!! Form::label("vehiculos[$i][patente_camion]", 'Patente camión:') !!}
                        {!! Form::text("vehiculos[$i][patente_camion]", $v['patente_camion'] ?? null, [
                            'class' => 'form-control',
                            'placeholder' => 'Ej: AB-CD-12'
                        ]) !!}
                    </div>

                    <!-- Patente remolque -->
                    <div class="form-group col-sm-4">
                        {!! Form::label("vehiculos[$i][patente_remolque]", 'Patente remolque:') !!}
                        {!! Form::text("vehiculos[$i][patente_remolque]", $v['patente_remolque'] ?? null, [
                            'class' => 'form-control',
                            'placeholder' => 'Opcional'
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Template HTML para clonar (no se envía al servidor) --}}
<template id="vehiculoTemplate">
    <div class="card mb-3 vehiculo-item" data-index="__INDEX__">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <strong>Vehículo #__NUM__</strong>
                <span class="badge badge-secondary ml-2 badgePrincipal" style="display:none">Principal</span>
            </div>

            <button type="button" class="btn btn-sm btn-danger btnRemoveVehiculo">
                Quitar
            </button>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="vehiculos___INDEX___conductor">Conductor:</label>
                    <select name="vehiculos[__INDEX__][conductor]" class="form-control">
                        <option value="">Seleccione un conductor</option>
                        @foreach($conductores as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label for="vehiculos___INDEX___patente_camion">Patente camión:</label>
                    <input type="text" name="vehiculos[__INDEX__][patente_camion]" class="form-control" placeholder="Ej: AB-CD-12">
                </div>

                <div class="form-group col-sm-4">
                    <label for="vehiculos___INDEX___patente_remolque">Patente remolque:</label>
                    <input type="text" name="vehiculos[__INDEX__][patente_remolque]" class="form-control" placeholder="Opcional">
                </div>
            </div>
        </div>
    </div>
</template>

{{-- =========================
     DATOS DE ORIGEN
   ========================= --}}
<div class="col-12">
    <hr>
    <h5>Datos de origen</h5>
</div>

<!-- Contacto Origen -->
<div class="form-group col-sm-4">
    {!! Form::label('contacto_origen', 'Contacto en origen:') !!}
    {!! Form::text('contacto_origen', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre de contacto en origen'
    ]) !!}
</div>

<!-- Teléfono Origen -->
<div class="form-group col-sm-4">
    {!! Form::label('telefono_origen', 'Número de contacto (origen):') !!}
    {!! Form::text('telefono_origen', null, [
        'class' => 'form-control',
        'placeholder' => 'Ej: +56 9 1234 5678'
    ]) !!}
</div>

<!-- Dirección Origen -->
<div class="form-group col-sm-4">
    {!! Form::label('direccion_origen', 'Dirección origen:') !!}
    {!! Form::text('direccion_origen', null, [
        'class' => 'form-control',
        'placeholder' => 'Calle, número, ciudad'
    ]) !!}
</div>

<!-- Link Google Maps Origen -->
<div class="form-group col-sm-12">
    {!! Form::label('link_mapa_origen', 'Ubicación origen (Google Maps):') !!}
    {!! Form::text('link_mapa_origen', null, [
        'class' => 'form-control',
        'placeholder' => 'Pega aquí el enlace de Google Maps del origen'
    ]) !!}
</div>

{{-- =========================
     DATOS DE DESTINO
   ========================= --}}
<div class="col-12">
    <hr>
    <h5>Datos de destino</h5>
</div>

<!-- Contacto Destino -->
<div class="form-group col-sm-4">
    {!! Form::label('contacto_destino', 'Contacto en destino:') !!}
    {!! Form::text('contacto_destino', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre de contacto en destino'
    ]) !!}
</div>

<!-- Teléfono Destino -->
<div class="form-group col-sm-4">
    {!! Form::label('telefono_destino', 'Número de contacto (destino):') !!}
    {!! Form::text('telefono_destino', null, [
        'class' => 'form-control',
        'placeholder' => 'Ej: +56 9 8765 4321'
    ]) !!}
</div>

<!-- Dirección Destino -->
<div class="form-group col-sm-4">
    {!! Form::label('direccion_destino', 'Dirección destino:') !!}
    {!! Form::text('direccion_destino', null, [
        'class' => 'form-control',
        'placeholder' => 'Calle, número, ciudad'
    ]) !!}
</div>

<!-- Link Google Maps Destino -->
<div class="form-group col-sm-12">
    {!! Form::label('link_mapa_destino', 'Ubicación destino (Google Maps):') !!}
    {!! Form::text('link_mapa_destino', null, [
        'class' => 'form-control',
        'placeholder' => 'Pega aquí el enlace de Google Maps del destino'
    ]) !!}
</div>

<!-- Estado -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}

    {!! Form::select('estado', [
        'pendiente'    => 'Pendiente',
        'inicio_carga' => 'Inicio de carga',
        'en_transito'  => 'En tránsito',
        'entregada'    => 'Entregada',
    ],
    old('estado', $ot->estado ?? 'pendiente'),
    ['class' => 'form-control custom-select']) !!}
</div>

<!-- Observaciones -->
<div class="form-group col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, [
        'class' => 'form-control',
        'rows'  => 3
    ]) !!}
</div>

{{-- JS (sin jQuery) para agregar/quitar vehículos --}}
@push('scripts')
<script>
(function () {
    const wrapper = document.getElementById('vehiculosWrapper');
    const btnAdd = document.getElementById('btnAddVehiculo');
    const tpl = document.getElementById('vehiculoTemplate');

    function updateHeadersAndButtons() {
        const items = wrapper.querySelectorAll('.vehiculo-item');

        items.forEach((item, idx) => {
            item.dataset.index = idx;

            // Header "Vehículo #"
            const strong = item.querySelector('.card-header strong');
            if (strong) strong.textContent = 'Vehículo #' + (idx + 1);

            // Principal badge
            const badge = item.querySelector('.badgePrincipal') || item.querySelector('.badge');
            const isFirst = idx === 0;

            // Si es el primer card, mostramos badge principal
            if (badge) {
                if (badge.classList.contains('badgePrincipal')) {
                    badge.style.display = isFirst ? '' : 'none';
                } else {
                    // En cards renderizados por PHP el primero trae badge fijo
                    // No hacemos nada aquí.
                }
            }

            // Renombrar inputs name="vehiculos[__][x]"
            item.querySelectorAll('input, select, textarea').forEach(el => {
                if (!el.name) return;

                el.name = el.name
                    .replace(/vehiculos\[\d+\]\[conductor\]/, `vehiculos[${idx}][conductor]`)
                    .replace(/vehiculos\[\d+\]\[patente_camion\]/, `vehiculos[${idx}][patente_camion]`)
                    .replace(/vehiculos\[\d+\]\[patente_remolque\]/, `vehiculos[${idx}][patente_remolque]`);

                // template usa __INDEX__ (si entró directo)
                el.name = el.name
                    .replace(/vehiculos\[\__INDEX__\]\[conductor\]/, `vehiculos[${idx}][conductor]`)
                    .replace(/vehiculos\[\__INDEX__\]\[patente_camion\]/, `vehiculos[${idx}][patente_camion]`)
                    .replace(/vehiculos\[\__INDEX__\]\[patente_remolque\]/, `vehiculos[${idx}][patente_remolque]`);
            });

            // Botón quitar: si solo queda 1, ocultar
            const btnRemove = item.querySelector('.btnRemoveVehiculo');
            if (btnRemove) {
                btnRemove.style.display = (items.length === 1) ? 'none' : '';
            }
        });

        // Asegura que el primer item tenga badge principal (en items nuevos)
        const first = wrapper.querySelector('.vehiculo-item');
        if (first) {
            const badge = first.querySelector('.badgePrincipal');
            if (badge) badge.style.display = '';
        }
    }

    function addVehiculo() {
        const nextIndex = wrapper.querySelectorAll('.vehiculo-item').length;
        const html = tpl.innerHTML
            .replaceAll('__INDEX__', String(nextIndex))
            .replaceAll('__NUM__', String(nextIndex + 1));

        const temp = document.createElement('div');
        temp.innerHTML = html.trim();
        const node = temp.firstElementChild;

        wrapper.appendChild(node);
        updateHeadersAndButtons();
    }

    function removeVehiculo(btn) {
        const card = btn.closest('.vehiculo-item');
        if (!card) return;
        card.remove();
        updateHeadersAndButtons();
    }

    // Add
    if (btnAdd) {
        btnAdd.addEventListener('click', addVehiculo);
    }

    // Remove (delegación)
    if (wrapper) {
        wrapper.addEventListener('click', function (e) {
            const btn = e.target.closest('.btnRemoveVehiculo');
            if (!btn) return;
            removeVehiculo(btn);
        });
    }

    // Inicial
    updateHeadersAndButtons();
})();
</script>
@endpush
