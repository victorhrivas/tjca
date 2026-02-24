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

<!-- Km Field -->
<div class="form-group col-sm-6">
    {!! Form::label('km', 'Km:') !!}
    {!! Form::number('km', null, ['class' => 'form-control']) !!}
</div>

<!-- Cama Baja 25 Ton Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cama_baja_25_ton', 'Cama Baja 25 Ton:') !!}
    {!! Form::number('cama_baja_25_ton', null, ['class' => 'form-control']) !!}
</div>

<!-- Rampla Autodescargable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rampla_autodescargable', 'Rampla Autodescargable:') !!}
    {!! Form::number('rampla_autodescargable', null, ['class' => 'form-control']) !!}
</div>

<!-- Rampla Plana Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rampla_plana', 'Rampla Plana:') !!}
    {!! Form::number('rampla_plana', null, ['class' => 'form-control']) !!}
</div>

<!-- Autodescargable 10 Ton Field -->
<div class="form-group col-sm-6">
    {!! Form::label('autodescargable_10_ton', 'Autodescargable 10 Ton:') !!}
    {!! Form::number('autodescargable_10_ton', null, ['class' => 'form-control']) !!}
</div>