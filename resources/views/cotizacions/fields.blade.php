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
                >
                    #{{ $solicitud->id }}
                    · {{ optional($solicitud->cliente)->razon_social }}
                    · {{ $solicitud->origen }} → {{ $solicitud->destino }}
                </option>
            @endforeach
        </select>
    @endif
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

    const inputOrigen  = document.querySelector('input[name="origen"]');
    const inputDestino = document.querySelector('input[name="destino"]');
    const inputCliente = document.querySelector('input[name="cliente"]');

    selectSolicitud.addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        if (!option) return;

        const origen  = option.getAttribute('data-origen')  || '';
        const destino = option.getAttribute('data-destino') || '';
        const cliente = option.getAttribute('data-cliente') || '';

        if (inputOrigen)  inputOrigen.value  = origen;
        if (inputDestino) inputDestino.value = destino;
        if (inputCliente) inputCliente.value = cliente;
    });
});
</script>
@endpush
