<!-- Cotizacion Id Field -->
<div class="col-sm-12">
    {!! Form::label('cotizacion_id', 'Cotizacion Id:') !!}
    <p>{{ $ot->cotizacion_id }}</p>
</div>

<!-- Conductor Field -->
<div class="col-sm-12">
    {!! Form::label('conductor', 'Conductor:') !!}
    <p>{{ $ot->conductor }}</p>
</div>

<!-- Patente Camion Field -->
<div class="col-sm-12">
    {!! Form::label('patente_camion', 'Patente Camion:') !!}
    <p>{{ $ot->patente_camion }}</p>
</div>

<!-- Patente Remolque Field -->
<div class="col-sm-12">
    {!! Form::label('patente_remolque', 'Patente Remolque:') !!}
    <p>{{ $ot->patente_remolque }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $ot->estado }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $ot->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $ot->updated_at }}</p>
</div>

