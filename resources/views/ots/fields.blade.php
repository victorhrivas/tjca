<!-- Cotizacion Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cotizacion_id', 'Cotizacion Id:') !!}
    {!! Form::number('cotizacion_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Conductor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('conductor', 'Conductor:') !!}
    {!! Form::text('conductor', null, ['class' => 'form-control']) !!}
</div>

<!-- Patente Camion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patente_camion', 'Patente Camion:') !!}
    {!! Form::text('patente_camion', null, ['class' => 'form-control']) !!}
</div>

<!-- Patente Remolque Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patente_remolque', 'Patente Remolque:') !!}
    {!! Form::text('patente_remolque', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::text('created_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {!! Form::text('updated_at', null, ['class' => 'form-control']) !!}
</div>