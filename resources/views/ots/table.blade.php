<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="ots-table">
            <thead>
            <tr>
                <th>OT</th>
                <th>Cliente</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Conductor</th>
                <th>Pat. Camión</th>
                <th>Estado</th>
                <th colspan="3">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($ots as $ot)
                @php
                    // Mapeo de estados con estilos similares a Cotizaciones
                    $estadosDisponibles = [
                        'pendiente'      => ['label' => 'Pendiente',       'class' => 'bg-warning text-dark'],
                        'inicio_carga'   => ['label' => 'Inicio de carga', 'class' => 'bg-info text-white'],
                        'en_transito'    => ['label' => 'En tránsito',     'class' => 'bg-primary text-white'],
                        'entregada'      => ['label' => 'Entregada',       'class' => 'bg-success text-white'],
                        'con_incidencia' => ['label' => 'Con incidencia',  'class' => 'bg-danger text-white'],
                    ];

                    $estadoActual = $ot->estado ?? 'pendiente';
                    $cfg = $estadosDisponibles[$estadoActual] ?? $estadosDisponibles['pendiente'];
                @endphp

                <tr>
                    {{-- OT (folio visible + id interno en pequeño) --}}
                    <td>
                        @if($ot->folio)
                            <strong>{{ $ot->folio }}</strong><br>
                        @else
                            #{{ $ot->id }}
                        @endif
                    </td>

                    {{-- Cliente --}}
                    <td>
                        {{ optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social ?? '-' }}
                    </td>

                    {{-- Origen / Destino --}}
                    <td>{{ optional(optional($ot->cotizacion)->solicitud)->origen ?? '-' }}</td>
                    <td>{{ optional(optional($ot->cotizacion)->solicitud)->destino ?? '-' }}</td>

                    {{-- Conductor / Patentes --}}
                    <td>{{ $ot->conductor ?: '-' }}</td>
                    <td>{{ $ot->patente_camion ?: '-' }}</td>

                    {{-- ESTADO: badge + dropdown para cambiar, pero visualmente igual que Cotizaciones --}}
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

                    {{-- ACCIONES: mismo estilo que Cotizaciones --}}
                    <td style="width: 150px">
                        {!! Form::open(['route' => ['ots.destroy', $ot->id], 'method' => 'delete']) !!}
                        <div class="btn-group">

                            {{-- Ver --}}
                            <a href="{{ route('ots.show', $ot->id) }}"
                               class="btn btn-default btn-xs"
                               title="Ver">
                                <i class="far fa-eye"></i>
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('ots.edit', $ot->id) }}"
                               class="btn btn-default btn-xs"
                               title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            {{-- Eliminar --}}
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
