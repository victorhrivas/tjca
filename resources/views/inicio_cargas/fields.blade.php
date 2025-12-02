<!-- Ot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ot_id', 'Ot Id:') !!}
    {!! Form::number('ot_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Cliente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente', 'Cliente:') !!}
    {!! Form::text('cliente', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Contacto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contacto', 'Contacto:') !!}
    {!! Form::text('contacto', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Contacto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono_contacto', 'Telefono Contacto:') !!}
    {!! Form::text('telefono_contacto', null, ['class' => 'form-control']) !!}
</div>

<!-- Correo Contacto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo_contacto', 'Correo Contacto:') !!}
    {!! Form::email('correo_contacto', null, ['class' => 'form-control']) !!}
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

@php
    // valor actual para cuando se edita o se vuelve por validación
    $valorTipoCarga = old('tipo_carga', $inicioCarga->tipo_carga ?? null);
    $opcionesCarga = [
        'Excavadora',
        'Generador',
        'Bulldozer',
        'Motoniveladora',
        'Cargador Frontal',
        'Contenedores',
        'TDI',
        'Rodillo',
        'Retroexcavadora',
        'Minicargador',
    ];
    $esOtro = $valorTipoCarga && !in_array($valorTipoCarga, $opcionesCarga);
@endphp

<!-- Tipo Carga Field (radio + otro) -->
<div class="form-group col-sm-12">
    {!! Form::label('tipo_carga', '¿Qué carga es?') !!}

    <div class="row">
        @foreach($opcionesCarga as $opcion)
            <div class="col-sm-6">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           name="tipo_carga_radio"
                           id="tipo_{{ strtolower(str_replace(' ', '_', $opcion)) }}"
                           value="{{ $opcion }}"
                           {{ $valorTipoCarga === $opcion ? 'checked' : '' }}>
                    <label class="form-check-label"
                           for="tipo_{{ strtolower(str_replace(' ', '_', $opcion)) }}">
                        {{ $opcion }}
                    </label>
                </div>
            </div>
        @endforeach

        {{-- Opción "Otro" --}}
        <div class="col-sm-12 mt-2">
            <div class="form-check d-flex align-items-center">
                <input class="form-check-input"
                       type="radio"
                       name="tipo_carga_radio"
                       id="tipo_otro"
                       value="__otro__"
                       {{ $esOtro ? 'checked' : '' }}>
                <label class="form-check-label mr-2" for="tipo_otro">Otro:</label>

                <input type="text"
                       id="tipo_carga_otro"
                       class="form-control form-control-sm"
                       style="max-width: 300px;"
                       placeholder="Especifica la carga"
                       value="{{ $esOtro ? $valorTipoCarga : '' }}"
                       {{ $esOtro ? '' : 'disabled' }}>
            </div>
        </div>
    </div>

    {{-- campo real que se guarda en la BD --}}
    <input type="hidden" name="tipo_carga" id="tipo_carga_hidden" value="{{ $valorTipoCarga }}">
</div>

<!-- Peso Aproximado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('peso_aproximado', 'Peso Aproximado:') !!}
    {!! Form::text('peso_aproximado', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Carga Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_carga', 'Fecha Carga:') !!}
    {!! Form::text('fecha_carga', null, ['class' => 'form-control','id'=>'fecha_carga']) !!}
</div>

<!-- Hora Presentacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hora_presentacion', 'Hora Presentacion:') !!}
    {!! Form::text('hora_presentacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        // datepicker existente
        $('#fecha_carga').datepicker();

        // lógica "tipo de carga" + "Otro"
        (function () {
            function syncTipoCarga() {
                const seleccionado = document.querySelector('input[name="tipo_carga_radio"]:checked');
                const hidden = document.getElementById('tipo_carga_hidden');
                const otroInput = document.getElementById('tipo_carga_otro');

                if (!seleccionado || !hidden) return;

                if (seleccionado.value === '__otro__') {
                    hidden.value = otroInput ? (otroInput.value || '') : '';
                } else {
                    hidden.value = seleccionado.value;
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const radios    = document.querySelectorAll('input[name="tipo_carga_radio"]');
                const otroRadio = document.getElementById('tipo_otro');
                const otroInput = document.getElementById('tipo_carga_otro');

                radios.forEach(function (r) {
                    r.addEventListener('change', function () {
                        if (otroRadio && otroInput) {
                            if (otroRadio.checked) {
                                otroInput.disabled = false;
                                otroInput.focus();
                            } else {
                                otroInput.disabled = true;
                            }
                        }
                        syncTipoCarga();
                    });
                });

                if (otroInput) {
                    otroInput.addEventListener('input', syncTipoCarga);
                }

                // estado inicial
                if (otroRadio && otroInput && otroRadio.checked) {
                    otroInput.disabled = false;
                }

                syncTipoCarga();
            });
        })();
    </script>
@endpush
