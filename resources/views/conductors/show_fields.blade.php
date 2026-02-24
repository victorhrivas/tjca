<!-- Nombre Field -->
<div class="col-sm-12">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{{ $conductor->nombre }}</p>
</div>

<!-- Rut Field -->
<div class="col-sm-12">
    {!! Form::label('rut', 'Rut:') !!}
    <p>{{ $conductor->rut }}</p>
</div>

<!-- Telefono Field -->
<div class="col-sm-12">
    {!! Form::label('telefono', 'Telefono:') !!}
    <p>{{ $conductor->telefono }}</p>
</div>

<!-- Correo Field -->
<div class="col-sm-12">
    {!! Form::label('correo', 'Correo:') !!}
    <p>{{ $conductor->correo }}</p>
</div>

<!-- Licencia Field -->
<div class="col-sm-12">
    {!! Form::label('licencia', 'Licencia:') !!}
    <p>{{ $conductor->licencia }}</p>
</div>

<!-- Activo Field -->
<div class="col-sm-12">
    {!! Form::label('activo', 'Activo:') !!}
    <p>{{ $conductor->activo }}</p>
</div>

