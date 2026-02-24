<!-- Razon Social Field -->
<div class="form-group col-sm-6">
    {!! Form::label('razon_social', 'Razon Social:') !!}
    {!! Form::text('razon_social', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Rut Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rut', 'Rut:') !!}
    {!! Form::text('rut', null, ['class' => 'form-control']) !!}
</div>

<!-- Giro Field -->
<div class="form-group col-sm-6">
    {!! Form::label('giro', 'Giro:') !!}
    {!! Form::text('giro', null, ['class' => 'form-control']) !!}
</div>

<hr>
<div class="col-12">
    <label class="d-block">Ejecutivos / contactos del cliente</label>

    <div class="table-responsive">
        <table class="table table-sm table-bordered" id="tablaEjecutivos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th style="width:140px;">Teléfono</th>
                    <th>Cargo</th>
                    <th style="width:110px;">Principal</th>
                    <th style="width:90px;">Activo</th>
                    <th style="width:60px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    // prioridad: old() -> $cliente->ejecutivos -> vacío
                    $ejRows = old('ejecutivos');

                    if ($ejRows === null) {
                        $ejRows = (isset($cliente) && $cliente->exists)
                            ? $cliente->ejecutivos->map(fn($e) => [
                                'id' => $e->id,
                                'nombre' => $e->nombre,
                                'correo' => $e->correo,
                                'telefono' => $e->telefono,
                                'cargo' => $e->cargo,
                                'es_principal' => (bool) $e->es_principal,
                                'activo' => (bool) $e->activo,
                            ])->toArray()
                            : [];
                    }
                @endphp

                @foreach($ejRows as $i => $row)
                    <tr>
                        <td>
                            @if(!empty($row['id']))
                                <input type="hidden" name="ejecutivos[{{ $i }}][id]" value="{{ $row['id'] }}">
                            @endif
                            <input class="form-control form-control-sm"
                                   name="ejecutivos[{{ $i }}][nombre]"
                                   value="{{ $row['nombre'] ?? '' }}"
                                   placeholder="Nombre"
                                   required>
                        </td>

                        <td>
                            <input class="form-control form-control-sm"
                                   type="email"
                                   name="ejecutivos[{{ $i }}][correo]"
                                   value="{{ $row['correo'] ?? '' }}"
                                   placeholder="correo@empresa.cl">
                        </td>

                        <td>
                            <input class="form-control form-control-sm"
                                   name="ejecutivos[{{ $i }}][telefono]"
                                   value="{{ $row['telefono'] ?? '' }}"
                                   placeholder="+56...">
                        </td>

                        <td>
                            <input class="form-control form-control-sm"
                                   name="ejecutivos[{{ $i }}][cargo]"
                                   value="{{ $row['cargo'] ?? '' }}"
                                   placeholder="Cargo">
                        </td>

                        <td class="text-center">
                            <input type="radio"
                                   class="js-principal"
                                   name="ejecutivo_principal"
                                   value="{{ $i }}"
                                   {{ !empty($row['es_principal']) ? 'checked' : '' }}>
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                   name="ejecutivos[{{ $i }}][activo]"
                                   value="1"
                                   {{ (!isset($row['activo']) || $row['activo']) ? 'checked' : '' }}>
                        </td>

                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm js-del-ej">×</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnAddEjecutivo">
        + Agregar ejecutivo
    </button>

    <small class="text-muted d-block mt-2">
        “Principal” es solo uno. Si no marcas ninguno, quedarán todos como no-principal.
    </small>
</div>

@push('scripts')
<script>
(function(){
    const tbody = document.querySelector('#tablaEjecutivos tbody');
    const btnAdd = document.getElementById('btnAddEjecutivo');

    function reindex(){
        [...tbody.querySelectorAll('tr')].forEach((tr, i) => {
            tr.querySelectorAll('input[name^="ejecutivos["]').forEach(inp => {
                inp.name = inp.name.replace(/ejecutivos\[\d+\]/, `ejecutivos[${i}]`);
            });

            // radio principal usa índice como value
            const radio = tr.querySelector('input.js-principal');
            if (radio) radio.value = i;
        });
    }

    btnAdd?.addEventListener('click', () => {
        const i = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input class="form-control form-control-sm" name="ejecutivos[${i}][nombre]" placeholder="Nombre" required>
            </td>
            <td>
                <input class="form-control form-control-sm" type="email" name="ejecutivos[${i}][correo]" placeholder="correo@empresa.cl">
            </td>
            <td>
                <input class="form-control form-control-sm" name="ejecutivos[${i}][telefono]" placeholder="+56...">
            </td>
            <td>
                <input class="form-control form-control-sm" name="ejecutivos[${i}][cargo]" placeholder="Cargo">
            </td>
            <td class="text-center">
                <input type="radio" class="js-principal" name="ejecutivo_principal" value="${i}">
            </td>
            <td class="text-center">
                <input type="checkbox" name="ejecutivos[${i}][activo]" value="1" checked>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm js-del-ej">×</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    tbody?.addEventListener('click', (e) => {
        if (e.target.classList.contains('js-del-ej')) {
            e.target.closest('tr')?.remove();
            reindex();
        }
    });
})();
</script>
@endpush

<!-- Correo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::email('correo', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Fecha de Creación:') !!}
    {!! Form::text('created_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Ultima Actualización:') !!}
    {!! Form::text('updated_at', null, ['class' => 'form-control']) !!}
</div>
