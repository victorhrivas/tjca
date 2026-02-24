<!-- Nombre Conductor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre_conductor', 'Nombre Conductor:') !!}
    {!! Form::text('nombre_conductor', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Patente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patente', 'Patente:') !!}
    {!! Form::text('patente', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Kilometraje Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kilometraje', 'Kilometraje:') !!}
    {!! Form::text('kilometraje', null, ['class' => 'form-control']) !!}
</div>

<!-- Nivel Aceite Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nivel_aceite', 'Nivel Aceite:') !!}
    {!! Form::text('nivel_aceite', null, ['class' => 'form-control']) !!}
</div>

<!-- Luces Altas Bajas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('luces_altas_bajas', 'Luces Altas Bajas:') !!}
    {!! Form::select('luces_altas_bajas', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Intermitentes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('intermitentes', 'Intermitentes:') !!}
    {!! Form::select('intermitentes', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Luces Posicion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('luces_posicion', 'Luces Posicion:') !!}
    {!! Form::select('luces_posicion', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Luces Freno Field -->
<div class="form-group col-sm-6">
    {!! Form::label('luces_freno', 'Luces Freno:') !!}
    {!! Form::select('luces_freno', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Estado Neumaticos Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('estado_neumaticos', 'Estado Neumaticos:') !!}
    {!! Form::textarea('estado_neumaticos', null, ['class' => 'form-control']) !!}
</div>

<!-- Sistema Frenos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sistema_frenos', 'Sistema Frenos:') !!}
    {!! Form::select('sistema_frenos', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Estado Espejos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado_espejos', 'Estado Espejos:') !!}
    {!! Form::select('estado_espejos', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Parabrisas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parabrisas', 'Parabrisas:') !!}
    {!! Form::select('parabrisas', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Calefaccion Ac Field -->
<div class="form-group col-sm-6">
    {!! Form::label('calefaccion_ac', 'Calefaccion Ac:') !!}
    {!! Form::select('calefaccion_ac', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Estado Tablones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado_tablones', 'Estado Tablones:') !!}
    {!! Form::select('estado_tablones', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Acumulacion Aire Field -->
<div class="form-group col-sm-6">
    {!! Form::label('acumulacion_aire', 'Acumulacion Aire:') !!}
    {!! Form::select('acumulacion_aire', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Extintor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('extintor', 'Extintor:') !!}
    {!! Form::select('extintor', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Neumatico Repuesto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('neumatico_repuesto', 'Neumatico Repuesto:') !!}
    {!! Form::select('neumatico_repuesto', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Asiento Conductor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asiento_conductor', 'Asiento Conductor:') !!}
    {!! Form::select('asiento_conductor', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Conos Cunas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('conos_cunas', 'Conos Cunas:') !!}
    {!! Form::select('conos_cunas', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Trinquetes Cadenas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trinquetes_cadenas', 'Trinquetes Cadenas:') !!}
    {!! Form::select('trinquetes_cadenas', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Ruidos Motor Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('ruidos_motor', 'Ruidos Motor:') !!}
    {!! Form::textarea('ruidos_motor', null, ['class' => 'form-control']) !!}
</div>

<!-- Detalle Mal Estado Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('detalle_mal_estado', 'Detalle Mal Estado:') !!}
    {!! Form::textarea('detalle_mal_estado', null, ['class' => 'form-control']) !!}
</div>