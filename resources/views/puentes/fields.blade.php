@php
    $otSeleccionadaId = old('ot_id', $ot->id ?? $puente->ot_id ?? '');
    $vehiculoSeleccionadoId = old('ot_vehiculo_id', $puente->ot_vehiculo_id ?? '');
    $nuevoConductorSeleccionado = old('nuevo_conductor', $puente->nuevo_conductor ?? '');
    $nuevoCamionSeleccionado = old('nueva_patente_camion', $puente->nueva_patente_camion ?? '');
    $nuevoRemolque = old('nueva_patente_remolque', $puente->nueva_patente_remolque ?? '');

    $otsPayload = $ots->map(function ($otItem) {
        return [
            'id' => $otItem->id,
            'folio' => $otItem->folio ?: '#'.$otItem->id,
            'cliente' => $otItem->cliente ?: 'Sin cliente',
            'origen' => $otItem->origen ?: '—',
            'destino' => $otItem->destino ?: '—',
            'vehiculos' => collect($otItem->vehiculos ?? [])->map(function ($vehiculo) {
                return [
                    'id' => $vehiculo->id,
                    'tipo_conductor' => $vehiculo->tipo_conductor,
                    'conductor' => $vehiculo->conductor ?: 'Sin conductor',
                    'patente_camion' => $vehiculo->patente_camion ?: '',
                    'patente_remolque' => $vehiculo->patente_remolque ?: '',
                    'label' => trim(
                        ($vehiculo->conductor ?: 'Sin conductor')
                        . ' - Camión: ' . ($vehiculo->patente_camion ?: '—')
                        . (!empty($vehiculo->patente_remolque) ? ' - Remolque: ' . $vehiculo->patente_remolque : '')
                    ),
                ];
            })->values()->toArray(),
        ];
    })->values()->toArray();

    $conductoresPayload = collect($conductores)->map(function ($label, $value) {
        return [
            'value' => $value,
            'label' => $label,
        ];
    })->values()->toArray();
@endphp

<div class="form-group col-sm-6">
    {!! Form::label('ot_id', 'OT:') !!}
    <select name="ot_id" id="ot_id" class="form-control" required>
        <option value="">Seleccione una OT</option>
        @foreach($ots as $otItem)
            <option value="{{ $otItem->id }}" {{ (string) $otSeleccionadaId === (string) $otItem->id ? 'selected' : '' }}>
                {{ $otItem->folio ?: '#'.$otItem->id }} - {{ $otItem->cliente ?: 'Sin cliente' }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('ot_vehiculo_id', 'Vehículo afectado:') !!}
    <select name="ot_vehiculo_id" id="ot_vehiculo_id" class="form-control">
        <option value="">Seleccione un vehículo</option>
    </select>
</div>

<div class="col-sm-12">
    <div class="card card-outline card-secondary mb-3" id="vehiculo_afectado_resumen" style="display:none;">
        <div class="card-header">
            <strong>Vehículo afectado</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Chofer</strong>
                    <div id="resumen_conductor">—</div>
                </div>
                <div class="col-md-4">
                    <strong>Camión</strong>
                    <div id="resumen_camion">—</div>
                </div>
                <div class="col-md-4">
                    <strong>Remolque</strong>
                    <div id="resumen_remolque">—</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('fase', 'Fase:') !!}
    {!! Form::select('fase', [
        'general' => 'General',
        'inicio_carga' => 'Inicio de carga',
        'en_transito' => 'En tránsito',
        'entrega' => 'Entrega',
    ], old('fase', $puente->fase ?? null), ['class' => 'form-control custom-select', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('motivo', 'Motivo:') !!}
    {!! Form::select('motivo', [
        'cambio_carga' => 'Cambio de carga',
        'cambio_conductor' => 'Cambio de conductor',
        'cambio_camion' => 'Cambio de camión',
        'accidente' => 'Accidente',
        'incidencia_operativa' => 'Incidencia operativa',
        'otro' => 'Otro',
    ], old('motivo', $puente->motivo ?? null), ['class' => 'form-control custom-select', 'id' => 'motivo', 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('detalle', 'Detalle:') !!}
    {!! Form::textarea('detalle', old('detalle', $puente->detalle ?? null), [
        'class' => 'form-control',
        'rows' => 4,
        'placeholder' => 'Describe lo ocurrido y la decisión tomada.'
    ]) !!}
</div>

<div class="form-group col-sm-6">
    <div class="form-check" style="margin-top: 32px;">
        {!! Form::hidden('notificar_cliente', 0) !!}
        {!! Form::checkbox('notificar_cliente', 1, old('notificar_cliente', $puente->notificar_cliente ?? false), [
            'class' => 'form-check-input',
            'id' => 'notificar_cliente'
        ]) !!}
        {!! Form::label('notificar_cliente', 'Notificar al cliente', ['class' => 'form-check-label']) !!}
    </div>
</div>

<div class="col-12">
    <hr>
    <h5 class="mb-0">Cambio aplicado</h5>
    <small class="text-muted">
        Si el motivo es cambio de chofer o cambio de camión, se habilitan automáticamente las opciones correspondientes.
    </small>
</div>

<div id="bloque_cambio_conductor" class="col-12 mt-3" style="display:none;">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <strong>Cambio de chofer</strong>
        </div>
        <div class="card-body">
            <div class="form-group mb-0">
                {!! Form::label('nuevo_conductor', 'Nuevo chofer:') !!}
                <select name="nuevo_conductor" id="nuevo_conductor" class="form-control">
                    <option value="">Seleccione un chofer</option>
                    @foreach($conductores as $value => $label)
                        <option value="{{ $value }}" {{ (string) $nuevoConductorSeleccionado === (string) $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div id="bloque_cambio_camion" class="col-12 mt-3" style="display:none;">
    <div class="card card-outline card-warning">
        <div class="card-header">
            <strong>Cambio de vehículo</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('nueva_patente_camion', 'Nuevo camión:') !!}
                    <select name="nueva_patente_camion" id="nueva_patente_camion" class="form-control">
                        <option value="">Seleccione un camión</option>
                    </select>
                </div>

                <div class="form-group col-sm-6">
                    {!! Form::label('nueva_patente_remolque', 'Nuevo remolque:') !!}
                    {!! Form::text('nueva_patente_remolque', $nuevoRemolque, [
                        'class' => 'form-control',
                        'id' => 'nueva_patente_remolque',
                        'placeholder' => 'Opcional'
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const otsData = @json($otsPayload);
    const conductoresData = @json($conductoresPayload);

    const otSelect = document.getElementById('ot_id');
    const vehiculoSelect = document.getElementById('ot_vehiculo_id');
    const motivoSelect = document.getElementById('motivo');

    const bloqueCambioConductor = document.getElementById('bloque_cambio_conductor');
    const bloqueCambioCamion = document.getElementById('bloque_cambio_camion');

    const nuevoConductorSelect = document.getElementById('nuevo_conductor');
    const nuevaPatenteCamionSelect = document.getElementById('nueva_patente_camion');

    const resumenCard = document.getElementById('vehiculo_afectado_resumen');
    const resumenConductor = document.getElementById('resumen_conductor');
    const resumenCamion = document.getElementById('resumen_camion');
    const resumenRemolque = document.getElementById('resumen_remolque');

    const selectedVehiculoId = @json($vehiculoSeleccionadoId);
    const selectedNuevoCamion = @json($nuevoCamionSeleccionado);

    function getOtById(id) {
        return otsData.find(ot => String(ot.id) === String(id));
    }

    function getVehiculoActual() {
        const ot = getOtById(otSelect.value);
        if (!ot || !ot.vehiculos) return null;
        return ot.vehiculos.find(v => String(v.id) === String(vehiculoSelect.value)) || null;
    }

    function renderVehiculos() {
        const ot = getOtById(otSelect.value);

        vehiculoSelect.innerHTML = '<option value="">Seleccione un vehículo</option>';

        if (!ot || !ot.vehiculos || !ot.vehiculos.length) {
            renderResumenVehiculo();
            return;
        }

        ot.vehiculos.forEach(v => {
            const option = document.createElement('option');
            option.value = v.id;
            option.textContent = v.label;
            vehiculoSelect.appendChild(option);
        });

        const optionExiste = Array.from(vehiculoSelect.options).some(opt => String(opt.value) === String(selectedVehiculoId));

        if (optionExiste) {
            vehiculoSelect.value = String(selectedVehiculoId);
        } else if (vehiculoSelect.options.length > 1) {
            vehiculoSelect.selectedIndex = 1;
        }

        renderResumenVehiculo();
    }

    function renderResumenVehiculo() {
        const vehiculo = getVehiculoActual();

        if (!vehiculo) {
            resumenCard.style.display = 'none';
            resumenConductor.textContent = '—';
            resumenCamion.textContent = '—';
            resumenRemolque.textContent = '—';
            return;
        }

        resumenCard.style.display = '';
        resumenConductor.textContent = vehiculo.conductor || '—';
        resumenCamion.textContent = vehiculo.patente_camion || '—';
        resumenRemolque.textContent = vehiculo.patente_remolque || '—';
    }

    function renderCamionesDisponibles() {
        const ot = getOtById(otSelect.value);

        nuevaPatenteCamionSelect.innerHTML = '<option value="">Seleccione un camión</option>';

        if (!ot || !ot.vehiculos || !ot.vehiculos.length) {
            return;
        }

        const actualVehiculoId = String(vehiculoSelect.value || '');
        const camiones = ot.vehiculos
            .filter(v => String(v.id) !== actualVehiculoId)
            .map(v => v.patente_camion)
            .filter(Boolean);

        const unicos = [...new Set(camiones)];

        unicos.forEach(patente => {
            const option = document.createElement('option');
            option.value = patente;
            option.textContent = patente;
            nuevaPatenteCamionSelect.appendChild(option);
        });

        if ([...nuevaPatenteCamionSelect.options].some(opt => String(opt.value) === String(selectedNuevoCamion))) {
            nuevaPatenteCamionSelect.value = String(selectedNuevoCamion);
        }
    }

    function toggleBloques() {
        const motivo = motivoSelect.value;

        bloqueCambioConductor.style.display = motivo === 'cambio_conductor' ? '' : 'none';
        bloqueCambioCamion.style.display = motivo === 'cambio_camion' ? '' : 'none';

        if (motivo !== 'cambio_conductor') {
            nuevoConductorSelect.value = '';
        }

        if (motivo !== 'cambio_camion') {
            nuevaPatenteCamionSelect.value = '';
        }
    }

    otSelect.addEventListener('change', function () {
        renderVehiculos();
        renderCamionesDisponibles();
    });

    vehiculoSelect.addEventListener('change', function () {
        renderResumenVehiculo();
        renderCamionesDisponibles();
    });

    motivoSelect.addEventListener('change', function () {
        toggleBloques();
    });

    renderVehiculos();
    renderCamionesDisponibles();
    toggleBloques();
})();
</script>
@endpush