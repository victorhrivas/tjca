@if ($errors->any())
<div class="alert alert-danger">
    <strong>Error al guardar:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Solicitud --}}
<div class="form-group col-sm-12">
    {!! Form::label('solicitud_id', 'Solicitud') !!}

    @if(isset($cotizacion) && $cotizacion->exists)
        {{-- Editar: solo texto --}}
        <p class="form-control-plaintext font-weight-bold" style="padding-left: 0;">
            #{{ $cotizacion->solicitud->id }}
            · {{ optional($cotizacion->solicitud->cliente)->razon_social }}
            · {{ $cotizacion->solicitud->origen }} → {{ $cotizacion->solicitud->destino }}
            · {{ optional($cotizacion->solicitud->created_at)->format('d/m/Y H:i') }}
        </p>

        <input type="hidden" name="solicitud_id" value="{{ $cotizacion->solicitud->id }}">
    @else
        {{-- Crear: selector con solicitudes precargadas --}}
        <select id="solicitud_id" name="solicitud_id" class="form-control" required>
            <option value="">Seleccionar solicitud...</option>
            @foreach($solicitudes as $solicitud)
                <option
                    value="{{ $solicitud->id }}"
                    data-origen="{{ $solicitud->origen }}"
                    data-destino="{{ $solicitud->destino }}"
                    data-cliente="{{ optional($solicitud->cliente)->razon_social }}"
                    data-solicitante="{{ $solicitud->solicitante }}"
                >
                    #{{ $solicitud->id }}
                    · {{ optional($solicitud->cliente)->razon_social }}
                    · {{ $solicitud->origen }} → {{ $solicitud->destino }}
                </option>
            @endforeach
        </select>
    @endif
</div>

{{-- Ejecutivo (User dueño de la cotización) --}}
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Ejecutivo') !!}

    @php
        // Orden deseado
        $nombresPermitidos = ['Jorge Contador Cerenic', 'Felipe Henott'];

        // Buscar ejecutivos existentes en BD
        $ejecutivosRaw = \App\Models\User::whereIn('name', $nombresPermitidos)
                        ->pluck('name', 'id'); // [id => nombre]

        // Reordenar según $nombresPermitidos: primero Jorge, luego Felipe
        $ejecutivos = [];
        foreach ($nombresPermitidos as $nombre) {
            $id = $ejecutivosRaw->search($nombre);
            if ($id !== false) {
                $ejecutivos[$id] = $nombre;
            }
        }

        // Determinar el ejecutivo seleccionado
        if (isset($cotizacion)) {
            // Editando → usar el user_id guardado
            $ejecutivoSeleccionado = $cotizacion->user_id;

        } else {
            // Creando → comportamiento dinámico

            if (empty($ejecutivos)) {
                // NO existen Jorge ni Felipe → usar SIEMPRE el usuario logeado
                $ejecutivoSeleccionado = auth()->id();

            } elseif (in_array(auth()->user()->name, $nombresPermitidos)) {
                // El logeado SÍ es Jorge o Felipe
                $ejecutivoSeleccionado = auth()->id();

            } else {
                // No es Jorge ni Felipe → usar el primero que exista (Jorge si está, si no Felipe)
                $ejecutivoSeleccionado = array_key_first($ejecutivos);
            }
        }
    @endphp

    {!! Form::select('user_id', $ejecutivos, $ejecutivoSeleccionado, [
        'class' => 'form-control',
        'placeholder' => empty($ejecutivos)
            ? 'No existen ejecutivos configurados (se guardará el usuario actual)'
            : 'Seleccione un ejecutivo...',
        'required'
    ]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('solicitante', 'Nombre solicitante / vendedor:') !!}
    {!! Form::text('solicitante', old('solicitante', $cotizacion->solicitante ?? null), [
        'class' => 'form-control',
        'placeholder' => 'Nombre del vendedor o solicitante',
        'required'
    ]) !!}
</div>

<!-- Origen -->
<div class="form-group col-sm-6">
    {!! Form::label('origen', 'Origen') !!}
    {!! Form::text('origen', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ej: Bodega Central'
    ]) !!}
</div>

<!-- Destino -->
<div class="form-group col-sm-6">
    {!! Form::label('destino', 'Destino') !!}
    {!! Form::text('destino', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ej: Sucursal 1'
    ]) !!}
</div>

<!-- Cliente (razón social ya “congelada”) -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente', 'Cliente') !!}
    {!! Form::text('cliente', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ej: Cliente 1 SPA'
    ]) !!}
</div>

<div class="col-12">
  <label class="d-block">Cargas / Ítems</label>

  <div class="table-responsive">
    <table class="table table-dark table-sm" id="tablaCargas">
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
        $rows = old('cargas', isset($cotizacion)
            ? $cotizacion->cargas->map(fn($c) => [
                'id' => $c->id,
                'descripcion' => $c->descripcion,
                'cantidad' => $c->cantidad,
                'precio_unitario' => $c->precio_unitario,
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
              <input class="form-control form-control-sm" name="cargas[{{ $i }}][descripcion]" value="{{ $row['descripcion'] ?? '' }}" required>
            </td>
            <td>
              <input class="form-control form-control-sm js-cantidad" type="number" step="0.01" min="0.01"
                     name="cargas[{{ $i }}][cantidad]" value="{{ $row['cantidad'] ?? 1 }}" required>
            </td>
            <td>
              <input class="form-control form-control-sm js-unit" type="number" step="1" min="0"
                     name="cargas[{{ $i }}][precio_unitario]" value="{{ $row['precio_unitario'] ?? 0 }}" required>
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

    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnAddCarga">
    + Agregar carga
    </button>


  <div class="mt-3">
    <label>Total (CLP)</label>
    <input class="form-control" id="monto_total_ui" type="text" readonly>
    {{-- si quieres mandar monto igual (no se usará), puedes incluir hidden --}}
    <input type="hidden" name="monto" id="monto_total_hidden" value="0">
  </div>
</div>

<!-- Estado -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado') !!}
    {!! Form::select('estado', [
        'enviada'   => 'Enviada',
        'aceptada'  => 'Aceptada',
        'rechazada' => 'Rechazada',
    ], null, ['class' => 'form-control custom-select', 'required']) !!}
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectSolicitud = document.getElementById('solicitud_id');
    if (!selectSolicitud) return;

    const inputOrigen      = document.querySelector('input[name="origen"]');
    const inputDestino     = document.querySelector('input[name="destino"]');
    const inputCliente     = document.querySelector('input[name="cliente"]');
    const inputSolicitante = document.querySelector('input[name="solicitante"]');

    selectSolicitud.addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        if (!option) return;

        inputOrigen.value      = option.getAttribute('data-origen')      || '';
        inputDestino.value     = option.getAttribute('data-destino')     || '';
        inputCliente.value     = option.getAttribute('data-cliente')     || '';
        inputSolicitante.value = option.getAttribute('data-solicitante') || '';
    });
});
</script>
@endpush

@push('scripts')
<script>
(function(){
  const tbody = document.querySelector('#tablaCargas tbody');
  const btnAdd = document.getElementById('btnAddCarga');
  const totalUI = document.getElementById('monto_total_ui');
  const totalHidden = document.getElementById('monto_total_hidden');

  function money(n){
    n = Math.round(n || 0);
    return n.toLocaleString('es-CL');
  }

  function recalc(){
    let total = 0;
    tbody.querySelectorAll('tr').forEach(tr => {
      const qty = parseFloat(tr.querySelector('.js-cantidad')?.value || 0);
      const unit = parseInt(tr.querySelector('.js-unit')?.value || 0, 10);
      const sub = Math.round(qty * unit);

      tr.querySelector('.js-subtotal').value = money(sub);
      total += sub;
    });

    totalUI.value = money(total);
    totalHidden.value = total;
  }

  function reindex(){
    // reindexa name="cargas[i][...]" para evitar huecos
    [...tbody.querySelectorAll('tr')].forEach((tr, i) => {
      tr.querySelectorAll('input[name^="cargas["]').forEach(inp => {
        inp.name = inp.name.replace(/cargas\[\d+\]/, `cargas[${i}]`);
      });
    });
  }

  btnAdd?.addEventListener('click', () => {
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

