<!-- Solicitud (buscable) -->
<div class="form-group col-sm-12">
    {!! Form::label('solicitud_id', 'Solicitud') !!}
    <select id="solicitud_id" name="solicitud_id" class="form-control" required>
    @isset($cotizacion->solicitud)
        <option value="{{ $cotizacion->solicitud->id }}" selected>
        #{{ $cotizacion->solicitud->id }} · {{ optional($cotizacion->solicitud->cliente)->razon_social }}
        · {{ $cotizacion->solicitud->origen }} → {{ $cotizacion->solicitud->destino }}
        · {{ optional($cotizacion->solicitud->created_at)->format('d/m/Y H:i') }}
        </option>
    @endisset
    </select>
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
