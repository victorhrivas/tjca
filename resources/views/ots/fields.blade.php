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

<!-- Conductor -->
<div class="form-group col-sm-6">
    {!! Form::label('conductor', 'Conductor:') !!}
    {!! Form::select('conductor', $conductores, null, [
        'class' => 'form-control',
        'placeholder' => 'Seleccione un conductor'
    ]) !!}
</div>

<!-- PATENTE CAMIÓN -->
<div class="form-group col-sm-6">
    {!! Form::label('patente_camion', 'Patente camión:') !!}
    {!! Form::text('patente_camion', null, ['class' => 'form-control']) !!}
</div>

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

{{-- Campo legacy opcional: link_mapa general (si quieres mantenerlo editable) --}}
{{-- 
<div class="form-group col-sm-6">
    {!! Form::label('link_mapa', 'Ubicación general (legacy):') !!}
    {!! Form::text('link_mapa', null, ['class' => 'form-control']) !!}
</div>
--}}

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
