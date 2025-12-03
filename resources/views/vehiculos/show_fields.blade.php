<!-- Marca Field -->
<div class="col-sm-12">
    {!! Form::label('marca', 'Marca:') !!}
    <p>{{ $vehiculo->marca }}</p>
</div>

<!-- Modelo Field -->
<div class="col-sm-12">
    {!! Form::label('modelo', 'Modelo:') !!}
    <p>{{ $vehiculo->modelo }}</p>
</div>

<!-- Anio Field -->
<div class="col-sm-12">
    {!! Form::label('anio', 'Anio:') !!}
    <p>{{ $vehiculo->anio }}</p>
</div>

<!-- Patente Field -->
<div class="col-sm-12">
    {!! Form::label('patente', 'Patente:') !!}
    <p>{{ $vehiculo->patente }}</p>
</div>

<!-- Informacion General Field -->
<div class="col-sm-12">
    {!! Form::label('informacion_general', 'Informacion General:') !!}
    <p>{{ $vehiculo->informacion_general }}</p>
</div>

