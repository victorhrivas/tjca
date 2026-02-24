<!-- Ot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ot_id', 'Ot Id:') !!}
    {!! Form::number('ot_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Nombre Receptor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre_receptor', 'Nombre Receptor:') !!}
    {!! Form::text('nombre_receptor', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Rut Receptor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rut_receptor', 'Rut Receptor:') !!}
    {!! Form::text('rut_receptor', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Receptor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono_receptor', 'Telefono Receptor:') !!}
    {!! Form::text('telefono_receptor', null, ['class' => 'form-control']) !!}
</div>

<!-- Correo Receptor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo_receptor', 'Correo Receptor:') !!}
    {!! Form::email('correo_receptor', null, ['class' => 'form-control']) !!}
</div>

<!-- Lugar Entrega Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lugar_entrega', 'Lugar Entrega:') !!}
    {!! Form::text('lugar_entrega', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Entrega Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_entrega', 'Fecha Entrega:') !!}
    {!! Form::text('fecha_entrega', null, ['class' => 'form-control','id'=>'fecha_entrega']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#fecha_entrega').datepicker()
    </script>
@endpush

<!-- Hora Entrega Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hora_entrega', 'Hora Entrega:') !!}
    {!! Form::text('hora_entrega', null, ['class' => 'form-control']) !!}
</div>

<!-- Conforme Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('conforme', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('conforme', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('conforme', 'Conforme', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Fotos Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('fotos', 'Fotos:') !!}
    {!! Form::textarea('fotos', null, ['class' => 'form-control']) !!}
</div>