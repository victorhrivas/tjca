<!-- Cliente Id Field -->
<div class="col-sm-12">
    {!! Form::label('cliente_id', 'Cliente Id:') !!}
    <p>{{ $solicitud->cliente_id }}</p>
</div>

<!-- Canal Field -->
<div class="col-sm-12">
    {!! Form::label('canal', 'Canal:') !!}
    <p>{{ $solicitud->canal }}</p>
</div>

<!-- Origen Field -->
<div class="col-sm-12">
    {!! Form::label('origen', 'Origen:') !!}
    <p>{{ $solicitud->origen }}</p>
</div>

<!-- Destino Field -->
<div class="col-sm-12">
    {!! Form::label('destino', 'Destino:') !!}
    <p>{{ $solicitud->destino }}</p>
</div>

<!-- Carga Field -->
<div class="col-sm-12">
    {!! Form::label('carga', 'Carga:') !!}
    <p>{{ $solicitud->carga }}</p>
</div>

<!-- Notas Field -->
<div class="col-sm-12">
    {!! Form::label('notas', 'Notas:') !!}
    <p>{{ $solicitud->notas }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $solicitud->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $solicitud->updated_at }}</p>
</div>

