<!-- Ot Id Field -->
<div class="col-sm-12">
    {!! Form::label('ot_id', 'Ot Id:') !!}
    <p>{{ $eventoOperacion->ot_id }}</p>
</div>

<!-- Tipo Field -->
<div class="col-sm-12">
    {!! Form::label('tipo', 'Tipo:') !!}
    <p>{{ $eventoOperacion->tipo }}</p>
</div>

<!-- Observaciones Field -->
<div class="col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{{ $eventoOperacion->observaciones }}</p>
</div>

<!-- Fotos Field -->
<div class="col-sm-12">
    {!! Form::label('fotos', 'Fotos:') !!}
    <p>{{ $eventoOperacion->fotos }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $eventoOperacion->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $eventoOperacion->updated_at }}</p>
</div>

