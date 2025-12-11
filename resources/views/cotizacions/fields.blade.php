{{-- Solicitud --}}
<div class="form-group col-sm-12">
    {!! Form::label('solicitud_id', 'Solicitud') !!}

    @if(isset($cotizacion) && $cotizacion->exists)
        {{-- Editar: solo texto --}}
        <p class="form-control-plaintext font-weight-bold" style="padding-left: 0;">
            #{{ $cotizacion->solicitud->id }}
            · {{ optional($cotizacion->solicitud->cliente)->razon_social }}
            · {{ $cotizacion->solicitud->origen }} → {{ $cotizacion->solicitud->destino }}
            · {{ optional($cotizacion->solicitud->created_at)->format('d/m/Y H:i') }}
        </p>

        <input type="hidden" name="solicitud_id" value="{{ $cotizacion->solicitud->id }}">
    @else
        {{-- Crear: selector con solicitudes precargadas --}}
        <select id="solicitud_id" name="solicitud_id" class="form-control" required>
            <option value="">Seleccionar solicitud...</option>
            @foreach($solicitudes as $solicitud)
                <option
                    value="{{ $solicitud->id }}"
                    data-origen="{{ $solicitud->origen }}"
                    data-destino="{{ $solicitud->destino }}"
                    data-cliente="{{ optional($solicitud->cliente)->razon_social }}"
                    data-solicitante="{{ $solicitud->solicitante }}"
                    data-carga="{{ $solicitud->carga }}"
                >
                    #{{ $solicitud->id }}
                    · {{ optional($solicitud->cliente)->razon_social }}
                    · {{ $solicitud->origen }} → {{ $solicitud->destino }}
                </option>
            @endforeach
        </select>
    @endif
</div>

{{-- Ejecutivo (User dueño de la cotización) --}}
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Ejecutivo') !!}

    @php
        // Orden deseado
        $nombresPermitidos = ['Jorge Contador', 'Felipe Henott'];

        // Buscar ejecutivos existentes en BD
        $ejecutivosRaw = \App\Models\User::whereIn('name', $nombresPermitidos)
                        ->pluck('name', 'id'); // [id => nombre]

        // Reordenar según $nombresPermitidos: primero Jorge, luego Felipe
        $ejecutivos = [];
        foreach ($nombresPermitidos as $nombre) {
            $id = $ejecutivosRaw->search($nombre);
            if ($id !== false) {
                $ejecutivos[$id] = $nombre;
            }
        }

        // Determinar el ejecutivo seleccionado
        if (isset($cotizacion)) {
            // Editando → usar el user_id guardado
            $ejecutivoSeleccionado = $cotizacion->user_id;

        } else {
            // Creando → comportamiento dinámico

            if (empty($ejecutivos)) {
                // NO existen Jorge ni Felipe → usar SIEMPRE el usuario logeado
                $ejecutivoSeleccionado = auth()->id();

            } elseif (in_array(auth()->user()->name, $nombresPermitidos)) {
                // El logeado SÍ es Jorge o Felipe
                $ejecutivoSeleccionado = auth()->id();

            } else {
                // No es Jorge ni Felipe → usar el primero que exista (Jorge si está, si no Felipe)
                $ejecutivoSeleccionado = array_key_first($ejecutivos);
            }
        }
    @endphp

    {!! Form::select('user_id', $ejecutivos, $ejecutivoSeleccionado, [
        'class' => 'form-control',
        'placeholder' => empty($ejecutivos)
            ? 'No existen ejecutivos configurados (se guardará el usuario actual)'
            : 'Seleccione un ejecutivo...',
        'required'
    ]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('solicitante', 'Nombre solicitante / vendedor:') !!}
    {!! Form::text('solicitante', old('solicitante', $cotizacion->solicitante ?? null), [
        'class' => 'form-control',
        'placeholder' => 'Nombre del vendedor o solicitante',
        'required'
    ]) !!}
</div>

<!-- Origen -->
<div class="form-group col-sm-6">
    {!! Form::label('origen', 'Origen') !!}
    {!! Form::text('origen', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ej: Bodega Central'
    ]) !!}
</div>

<!-- Destino -->
<div class="form-group col-sm-6">
    {!! Form::label('destino', 'Destino') !!}
    {!! Form::text('destino', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ej: Sucursal 1'
    ]) !!}
</div>

<!-- Cliente (razón social ya “congelada”) -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente', 'Cliente') !!}
    {!! Form::text('cliente', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ej: Cliente 1 SPA'
    ]) !!}
</div>

<!-- Carga -->
<div class="form-group col-sm-6">
    {!! Form::label('carga', 'Carga') !!}
    {!! Form::text('carga', null, [
        'class' => 'form-control',
        'placeholder' => 'Ej: 200 kg / Pallets / Insumos médicos'
    ]) !!}
</div>


<!-- Estado -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado') !!}
    {!! Form::select('estado', [
        'enviada'   => 'Enviada',
        'aceptada'  => 'Aceptada',
        'rechazada' => 'Rechazada',
    ], null, ['class' => 'form-control custom-select', 'required']) !!}
</div>

<!-- Monto -->
<div class="form-group col-sm-6">
    {!! Form::label('monto', 'Monto (CLP)') !!}
    {!! Form::number('monto', null, ['class' => 'form-control', 'min'=>0, 'step'=>1]) !!}
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectSolicitud = document.getElementById('solicitud_id');
    if (!selectSolicitud) return;

    const inputOrigen      = document.querySelector('input[name="origen"]');
    const inputDestino     = document.querySelector('input[name="destino"]');
    const inputCliente     = document.querySelector('input[name="cliente"]');
    const inputSolicitante = document.querySelector('input[name="solicitante"]');
    const inputCarga       = document.querySelector('input[name="carga"]');

    selectSolicitud.addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        if (!option) return;

        inputOrigen.value      = option.getAttribute('data-origen')      || '';
        inputDestino.value     = option.getAttribute('data-destino')     || '';
        inputCliente.value     = option.getAttribute('data-cliente')     || '';
        inputSolicitante.value = option.getAttribute('data-solicitante') || '';
        inputCarga.value       = option.getAttribute('data-carga')       || '';
    });
});
</script>
@endpush
