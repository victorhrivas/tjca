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
    {!! Form::label('origen', 'Origen:') !!}
    {!! Form::text('origen', null, ['class' => 'form-control']) !!}
</div>

<!-- Destino -->
<div class="form-group col-sm-6">
    {!! Form::label('destino', 'Destino:') !!}
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

<!-- Conductor -->
<div class="form-group col-sm-6">
    {!! Form::label('conductor', 'Conductor:') !!}
    {!! Form::select('conductor', $conductores, null, [
        'class' => 'form-control',
        'placeholder' => 'Seleccione un conductor'
    ]) !!}
</div>

<!-- Contacto Origen -->
<div class="form-group col-sm-6">
    {!! Form::label('contacto_origen', 'Contacto en origen:') !!}
    {!! Form::text('contacto_origen', null, [
        'class' => 'form-control',
        'placeholder' => 'Persona y teléfono de contacto en origen'
    ]) !!}
</div>

<!-- Contacto Destino -->
<div class="form-group col-sm-6">
    {!! Form::label('contacto_destino', 'Contacto en destino:') !!}
    {!! Form::text('contacto_destino', null, [
        'class' => 'form-control',
        'placeholder' => 'Persona y teléfono de contacto en destino'
    ]) !!}
</div>

<!-- Link Google Maps Destino -->
<div class="form-group col-sm-6">
    {!! Form::label('link_mapa', 'Ubicación destino (Google Maps):') !!}
    {!! Form::text('link_mapa', null, [
        'class' => 'form-control',
        'placeholder' => 'Pegue aquí el enlace de Google Maps'
    ]) !!}
</div>

<!-- Patente Camión -->
<div class="form-group col-sm-6">
    {!! Form::label('patente_camion', 'Patente camión:') !!}
    {!! Form::text('patente_camion', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', [
        'inicio_carga' => 'Inicio de carga',
        'en_transito'  => 'En tránsito',
        'entregada'    => 'Entregada',
    ], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Observaciones -->
<div class="form-group col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, [
        'class' => 'form-control',
        'rows'  => 3
    ]) !!}
</div>
