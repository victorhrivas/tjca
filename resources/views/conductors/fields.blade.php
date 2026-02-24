<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Rut Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rut', 'Rut:') !!}
    {!! Form::text('rut', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>

<!-- Correo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::email('correo', null, ['class' => 'form-control']) !!}
</div>

<!-- Licencia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('licencia', 'Licencia:') !!}
    {!! Form::text('licencia', null, ['class' => 'form-control']) !!}
</div>

<!-- Activo Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('activo', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('activo', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('activo', 'Activo', ['class' => 'form-check-label']) !!}
    </div>
</div>