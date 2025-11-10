<!-- Ot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ot_id', 'Ot Id:') !!}
    {!! Form::number('ot_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Fase Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fase', 'Fase:') !!}
    {!! Form::select('fase', [], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Motivo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('motivo', 'Motivo:') !!}
    {!! Form::text('motivo', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Detalle Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('detalle', 'Detalle:') !!}
    {!! Form::textarea('detalle', null, ['class' => 'form-control']) !!}
</div>

<!-- Notificar Cliente Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('notificar_cliente', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('notificar_cliente', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('notificar_cliente', 'Notificar Cliente', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::text('created_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {!! Form::text('updated_at', null, ['class' => 'form-control']) !!}
</div>