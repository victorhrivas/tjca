<!-- Cliente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente_id', 'Cliente:') !!}
    {!! Form::select('cliente_id', $clientes, old('cliente_id', $solicitud->cliente_id ?? null), [
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
        'llamada'  => 'Llamada',
        'email'    => 'Email',
        'otro'     => 'Otro'
    ], old('canal', $solicitud->canal ?? null), [
        'class' => 'form-control',
        'placeholder' => 'Seleccione un canal...',
        'required'
    ]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('solicitante', 'Nombre solicitante / vendedor:') !!}
    {!! Form::text('solicitante', old('solicitante', $solicitud->solicitante ?? null), [
        'class' => 'form-control',
        'placeholder' => 'Nombre del vendedor o solicitante',
        'required'
    ]) !!}
</div>

<!-- Origen Field -->
<div class="form-group col-sm-6">
    {!! Form::label('origen', 'Origen:') !!}
    {!! Form::text('origen', old('origen', $solicitud->origen ?? null), [
        'class' => 'form-control',
        'required'
    ]) !!}
</div>

<!-- Destino Field -->
<div class="form-group col-sm-6">
    {!! Form::label('destino', 'Destino:') !!}
    {!! Form::text('destino', old('destino', $solicitud->destino ?? null), [
        'class' => 'form-control',
        'required'
    ]) !!}
</div>

<div class="col-12">
    <label class="d-block">Cargas / Ítems</label>

    <div class="table-responsive">
        <table class="table table-sm table-dark" id="tablaCargasSolicitud">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th style="width:140px;">Cantidad</th>
                    <th style="width:170px;">Precio unitario (CLP)</th>
                    <th style="width:170px;">Subtotal</th>
                    <th style="width:60px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rows = old('cargas', isset($solicitud)
                        ? $solicitud->cargas->map(fn($c) => [
                            'id'             => $c->id,
                            'descripcion'    => $c->descripcion,
                            'cantidad'       => $c->cantidad,
                            'precio_unitario'=> $c->precio_unitario ?? 0,
                        ])->toArray()
                        : [
                            ['descripcion' => '', 'cantidad' => 1, 'precio_unitario' => 0]
                        ]
                    );
                @endphp

                @foreach($rows as $i => $row)
                    <tr>
                        <td>
                            @if(!empty($row['id']))
                                <input type="hidden" name="cargas[{{ $i }}][id]" value="{{ $row['id'] }}">
                            @endif

                            <input class="form-control form-control-sm"
                                   name="cargas[{{ $i }}][descripcion]"
                                   value="{{ $row['descripcion'] ?? '' }}" required>
                        </td>
                        <td>
                            <input class="form-control form-control-sm js-cantidad"
                                   type="number" step="0.01" min="0.01"
                                   name="cargas[{{ $i }}][cantidad]"
                                   value="{{ $row['cantidad'] ?? 1 }}" required>
                        </td>
                        <td>
                            <input class="form-control form-control-sm js-unit"
                                   type="number" step="1" min="0"
                                   name="cargas[{{ $i }}][precio_unitario]"
                                   value="{{ $row['precio_unitario'] ?? 0 }}" required>
                        </td>
                        <td>
                            <input class="form-control form-control-sm js-subtotal" type="text" value="0" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm js-del">×</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnAddCargaSolicitud">
        + Agregar carga
    </button>

    <div class="mt-3">
        <label>Total (CLP)</label>
        <input class="form-control" id="solicitud_total_ui" type="text" readonly>
    </div>
</div>

<!-- Valor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('valor', 'Valor estimado (CLP):') !!}
    {!! Form::number('valor', old('valor', $solicitud->valor ?? 0), [
        'class' => 'form-control',
        'readonly',
        'id' => 'valor_estimado',
    ]) !!}
    <small class="text-muted">Calculado automáticamente desde las cargas.</small>
</div>

<!-- Notas Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('notas', 'Notas:') !!}
    {!! Form::textarea('notas', old('notas', $solicitud->notas ?? 'Sin información adicional'), [
        'class' => 'form-control'
    ]) !!}
</div>

@push('scripts')
<script>
(function(){
  const tbody = document.querySelector('#tablaCargasSolicitud tbody');
  const btnAdd = document.getElementById('btnAddCargaSolicitud');
  const totalUI = document.getElementById('solicitud_total_ui');
  const valor = document.getElementById('valor_estimado');

  function money(n){
    n = Math.round(n || 0);
    return n.toLocaleString('es-CL');
  }

  function recalc(){
    if (!tbody) return;

    let total = 0;
    tbody.querySelectorAll('tr').forEach(tr => {
      const qty  = parseFloat(tr.querySelector('.js-cantidad')?.value || 0);
      const unit = parseInt(tr.querySelector('.js-unit')?.value || 0, 10);
      const sub  = Math.round(qty * unit);

      const subInput = tr.querySelector('.js-subtotal');
      if (subInput) subInput.value = money(sub);

      total += sub;
    });

    if (totalUI) totalUI.value = money(total);
    if (valor) valor.value = total; // SIEMPRE sincronizado
  }

  function reindex(){
    if (!tbody) return;

    [...tbody.querySelectorAll('tr')].forEach((tr, i) => {
      tr.querySelectorAll('input[name^="cargas["]').forEach(inp => {
        inp.name = inp.name.replace(/cargas\[\d+\]/, `cargas[${i}]`);
      });
    });
  }

  btnAdd?.addEventListener('click', () => {
    if (!tbody) return;

    const i = tbody.querySelectorAll('tr').length;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <input class="form-control form-control-sm" name="cargas[${i}][descripcion]" required>
      </td>
      <td>
        <input class="form-control form-control-sm js-cantidad" type="number" step="0.01" min="0.01"
               name="cargas[${i}][cantidad]" value="1" required>
      </td>
      <td>
        <input class="form-control form-control-sm js-unit" type="number" step="1" min="0"
               name="cargas[${i}][precio_unitario]" value="0" required>
      </td>
      <td>
        <input class="form-control form-control-sm js-subtotal" type="text" value="0" readonly>
      </td>
      <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm js-del">×</button>
      </td>
    `;
    tbody.appendChild(tr);
    recalc();
  });

  tbody?.addEventListener('input', (e) => {
    if (e.target.classList.contains('js-cantidad') || e.target.classList.contains('js-unit')) {
      recalc();
    }
  });

  tbody?.addEventListener('click', (e) => {
    if (e.target.classList.contains('js-del')) {
      e.target.closest('tr')?.remove();
      reindex();
      recalc();
    }
  });

  recalc();
})();
</script>
@endpush
