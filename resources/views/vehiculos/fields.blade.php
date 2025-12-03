<!-- Marca Field -->
<div class="form-group col-sm-6">
    {!! Form::label('marca', 'Marca:') !!}
    {!! Form::text('marca', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Modelo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('modelo', 'Modelo:') !!}
    {!! Form::text('modelo', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Anio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('anio', 'Anio:') !!}
    {!! Form::number('anio', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Patente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patente', 'Patente:') !!}
    {!! Form::text('patente', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Informacion General Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('informacion_general', 'Informacion General:') !!}
    {!! Form::textarea('informacion_general', null, ['class' => 'form-control']) !!}
</div>