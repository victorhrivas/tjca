<!-- Ot Id Field -->
<div class="col-sm-12">
    {!! Form::label('ot_id', 'Ot Id:') !!}
    <p>{{ $entrega->ot_id }}</p>
</div>

<!-- Nombre Receptor Field -->
<div class="col-sm-12">
    {!! Form::label('nombre_receptor', 'Nombre Receptor:') !!}
    <p>{{ $entrega->nombre_receptor }}</p>
</div>

<!-- Rut Receptor Field -->
<div class="col-sm-12">
    {!! Form::label('rut_receptor', 'Rut Receptor:') !!}
    <p>{{ $entrega->rut_receptor }}</p>
</div>

<!-- Telefono Receptor Field -->
<div class="col-sm-12">
    {!! Form::label('telefono_receptor', 'Telefono Receptor:') !!}
    <p>{{ $entrega->telefono_receptor }}</p>
</div>

<!-- Correo Receptor Field -->
<div class="col-sm-12">
    {!! Form::label('correo_receptor', 'Correo Receptor:') !!}
    <p>{{ $entrega->correo_receptor }}</p>
</div>

<!-- Lugar Entrega Field -->
<div class="col-sm-12">
    {!! Form::label('lugar_entrega', 'Lugar Entrega:') !!}
    <p>{{ $entrega->lugar_entrega }}</p>
</div>

<!-- Fecha Entrega Field -->
<div class="col-sm-12">
    {!! Form::label('fecha_entrega', 'Fecha Entrega:') !!}
    <p>{{ $entrega->fecha_entrega }}</p>
</div>

<!-- Hora Entrega Field -->
<div class="col-sm-12">
    {!! Form::label('hora_entrega', 'Hora Entrega:') !!}
    <p>{{ $entrega->hora_entrega }}</p>
</div>

<!-- Conforme Field -->
<div class="col-sm-12">
    {!! Form::label('conforme', 'Conforme:') !!}
    <p>{{ $entrega->conforme }}</p>
</div>

<!-- Observaciones Field -->
<div class="col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{{ $entrega->observaciones }}</p>
</div>

