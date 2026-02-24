<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="ots-table">
            <thead>
            <tr>
                <th>OT</th>
                <th>Cliente</th>
                <th>Origen</th>
                <th>Destino</th>

                {{-- Mostrar N vehículos --}}
                <th>Vehículos</th>

                <th>Estado</th>
                <th colspan="3">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($ots as $ot)
                @php
                    $estadosDisponibles = [
                        'pendiente'      => ['label' => 'Pendiente',       'class' => 'bg-warning text-dark'],
                        'inicio_carga'   => ['label' => 'Inicio de carga', 'class' => 'bg-info text-white'],
                        'en_transito'    => ['label' => 'En tránsito',     'class' => 'bg-primary text-white'],
                        'entregada'      => ['label' => 'Entregada',       'class' => 'bg-success text-white'],
                        'con_incidencia' => ['label' => 'Con incidencia',  'class' => 'bg-danger text-white'],
                    ];

                    $estadoActual = $ot->estado ?? 'pendiente';
                    $cfg = $estadosDisponibles[$estadoActual] ?? $estadosDisponibles['pendiente'];

                    $clienteNombre = $ot->cliente
                        ?? optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social
                        ?? '-';

                    $origen = $ot->origen
                        ?? optional(optional($ot->cotizacion)->solicitud)->origen
                        ?? '-';

                    $destino = $ot->destino
                        ?? optional(optional($ot->cotizacion)->solicitud)->destino
                        ?? '-';

                    // Vehículos: preferir relación si viene eager-loaded.
                    // Fallback: si no hay relación, construir 1 “vehículo” desde legacy.
                    $vehiculos = $ot->vehiculos ?? collect();

                    $tieneLegacy = !empty($ot->conductor) || !empty($ot->patente_camion) || !empty($ot->patente_remolque);

                    if ($vehiculos->isEmpty() && $tieneLegacy) {
                        $vehiculos = collect([(object)[
                            'conductor' => $ot->conductor,
                            'patente_camion' => $ot->patente_camion,
                            'patente_remolque' => $ot->patente_remolque,
                        ]]);
                    }
                @endphp

                <tr>
                    {{-- OT --}}
                    <td>
                        @if($ot->folio)
                            <strong>{{ $ot->folio }}</strong><br>
                        @else
                            <strong>#{{ $ot->id }}</strong><br>
                        @endif
                        <small class="text-muted">ID: {{ $ot->id }}</small>
                    </td>

                    <td>{{ $clienteNombre }}</td>
                    <td>{{ $origen }}</td>
                    <td>{{ $destino }}</td>

                    {{-- Vehículos (N) --}}
                    <td style="min-width: 260px;">
                        @if($vehiculos->isEmpty())
                            <span class="text-muted">—</span>
                        @else
                            {{-- Resumen + detalle expandible --}}
                            <div>
                                <span class="badge badge-secondary" style="border-radius:6px;">
                                    {{ $vehiculos->count() }} vehículo{{ $vehiculos->count() === 1 ? '' : 's' }}
                                </span>

                                <details class="mt-1">
                                    <summary class="text-muted" style="cursor:pointer; font-size:12px;">
                                        Ver lista
                                    </summary>

                                    <div class="mt-2">
                                        @foreach($vehiculos as $i => $v)
                                            <div class="text-muted" style="font-size: 12px; line-height: 1.25; margin-bottom: 6px;">
                                                <strong>#{{ $i + 1 }}</strong>
                                                · {{ $v->conductor ?: 'Sin conductor' }}
                                                <br>
                                                <span>
                                                    Camión: {{ $v->patente_camion ?: '—' }}
                                                    @if(!empty($v->patente_remolque))
                                                        · Remolque: {{ $v->patente_remolque }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @endif
                    </td>

                    {{-- Estado --}}
                    <td>
                        <div class="btn-group">
                            <button type="button"
                                    class="btn btn-default btn-xs dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                <span class="badge {{ $cfg['class'] }}"
                                      style="font-size:11px;padding:4px 8px;border-radius:6px;">
                                    {{ $cfg['label'] }}
                                </span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($estadosDisponibles as $value => $data)
                                    @if($value !== $estadoActual)
                                        <form method="POST" action="{{ route('ots.updateEstado', $ot) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="{{ $value }}">

                                            <button type="submit"
                                                    class="dropdown-item small d-flex align-items-center">
                                                <span class="badge {{ $data['class'] }} mr-2"
                                                      style="width:14px;height:14px;border-radius:999px;padding:0;">
                                                    &nbsp;
                                                </span>
                                                <span>{{ $data['label'] }}</span>
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </td>

                    {{-- Acciones --}}
                    <td style="width: 150px">
                        {!! Form::open(['route' => ['ots.destroy', $ot->id], 'method' => 'delete']) !!}
                        <div class="btn-group">
                            <a href="{{ route('ots.show', $ot->id) }}"
                               class="btn btn-default btn-xs"
                               title="Ver">
                                <i class="far fa-eye"></i>
                            </a>

                            <a href="{{ route('ots.edit', $ot->id) }}"
                               class="btn btn-default btn-xs"
                               title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type'    => 'submit',
                                'class'   => 'btn btn-danger btn-xs',
                                'title'   => 'Eliminar',
                                'onclick' => "return confirm('¿Eliminar esta OT?')"
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $ots])
        </div>
    </div>
</div>
