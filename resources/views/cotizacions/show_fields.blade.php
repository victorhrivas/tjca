<!-- Solicitud Id Field -->
<div class="col-sm-12">
    {!! Form::label('solicitud_id', 'Solicitud Id:') !!}
    <p>{{ $cotizacion->solicitud_id }}</p>
</div>

<!-- Estado Field -->
<div class="col-sm-12">
    {!! Form::label('estado', 'Estado:') !!}
    <p>{{ $cotizacion->estado }}</p>
</div>

<!-- Monto Field -->
<div class="col-sm-12">
    {!! Form::label('monto', 'Monto:') !!}
    <p>{{ $cotizacion->monto }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cotizacion->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cotizacion->updated_at }}</p>
</div>

