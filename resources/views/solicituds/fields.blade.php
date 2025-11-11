<!-- Cliente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente_id', 'Cliente:') !!}
    {!! Form::select('cliente_id', $clientes, null, [
        'class' => 'form-control',
        'placeholder' => 'Seleccione un cliente...',
        'required'
    ]) !!}
</div>

<!-- Canal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('canal', 'Canal:') !!}
    {!! Form::select('canal', [
        'whatsapp' => 'WhatsApp',
        'llamada' => 'Llamada',
        'email' => 'Email',
        'otro' => 'Otro'
    ], null, [
        'class' => 'form-control',
        'placeholder' => 'Seleccione un canal...',
        'required'
    ]) !!}
</div>

<!-- Origen Field -->
<div class="form-group col-sm-6">
    {!! Form::label('origen', 'Origen:') !!}
    {!! Form::text('origen', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Destino Field -->
<div class="form-group col-sm-6">
    {!! Form::label('destino', 'Destino:') !!}
    {!! Form::text('destino', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Carga Field -->
<div class="form-group col-sm-6">
    {!! Form::label('carga', 'Carga:') !!}
    {!! Form::text('carga', null, ['class' => 'form-control']) !!}
</div>

<!-- Notas Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('notas', 'Notas:') !!}
    {!! Form::textarea('notas', null, ['class' => 'form-control']) !!}
</div>