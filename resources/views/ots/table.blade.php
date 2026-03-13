<div class="card-body p-0">
    <style>
        .otx-page #ots-table{
            margin-bottom: 0;
            color: var(--otx-text);
            font-size: .84rem;
        }

        .otx-page #ots-table thead th{
            background: var(--otx-bg-head);
            color: var(--otx-text-strong);
            border-bottom: 1px solid var(--otx-border) !important;
            border-top: 0 !important;
            font-size: .72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .03em;
            white-space: nowrap;
            padding: 10px 10px;
            vertical-align: middle;
        }

        .otx-page #ots-table tbody td{
            border-color: var(--otx-border-soft) !important;
            padding: 8px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .otx-page #ots-table tbody tr{
            transition: background-color .15s ease;
        }

        .otx-page #ots-table tbody tr:nth-child(even){
            background: rgba(127, 127, 127, 0.03);
        }

        .otx-page #ots-table tbody tr:hover{
            background: rgba(59, 130, 246, 0.08);
        }

        .otx-page .otx-col-id{
            min-width: 95px;
            max-width: 95px;
            font-weight: 800;
            color: var(--otx-text-strong);
        }

        .otx-page .otx-col-cliente{
            min-width: 220px;
            max-width: 220px;
            font-weight: 700;
            color: var(--otx-text-strong);
        }

        .otx-page .otx-col-ubicacion{
            min-width: 150px;
            max-width: 150px;
        }

        .otx-page .otx-col-vehiculos{
            min-width: 260px;
            max-width: 260px;
        }

        .otx-page .otx-col-estado{
            min-width: 150px;
            max-width: 150px;
        }

        .otx-page .otx-col-acciones{
            min-width: 120px;
            max-width: 120px;
        }

        .otx-page .otx-truncate{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .otx-page .otx-id-main{
            font-weight: 800;
            color: var(--otx-text-strong);
            line-height: 1.1;
        }

        .otx-page .otx-id-sub{
            color: var(--otx-text-muted);
            font-size: .75rem;
            line-height: 1.1;
            margin-top: 2px;
            display: block;
        }

        .otx-page .otx-chip{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 800;
            line-height: 1;
            border: 1px solid transparent;
        }

        .otx-page .otx-chip-count{
            background: var(--otx-bg-head);
            color: var(--otx-text-strong);
            border-color: var(--otx-border);
        }

        .otx-page .otx-details{
            margin-top: 6px;
        }

        .otx-page .otx-details summary{
            cursor: pointer;
            color: var(--otx-text-muted);
            font-size: .74rem;
            outline: none;
            user-select: none;
        }

        .otx-page .otx-vehiculo-list{
            margin-top: 8px;
            padding: 8px 10px;
            border: 1px solid var(--otx-border);
            background: var(--otx-bg-soft);
            border-radius: 10px;
        }

        .otx-page .otx-vehiculo-item{
            font-size: .74rem;
            line-height: 1.3;
            color: var(--otx-text-muted);
        }

        .otx-page .otx-vehiculo-item + .otx-vehiculo-item{
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed var(--otx-border);
        }

        .otx-page .otx-badge{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 800;
            line-height: 1;
            border: 1px solid transparent;
            min-width: 110px;
        }

        .otx-page .otx-badge-pendiente{
            background: #facc15;
            color: #3b2f00;
        }

        .otx-page .otx-badge-inicio{
            background: #38bdf8;
            color: #082f49;
        }

        .otx-page .otx-badge-transito{
            background: #3b82f6;
            color: #ffffff;
        }

        .otx-page .otx-badge-entregada{
            background: #22c55e;
            color: #ffffff;
        }

        .otx-page .otx-badge-incidencia{
            background: #ef4444;
            color: #ffffff;
        }

        .otx-page .otx-estado-dropdown .btn{
            min-height: 30px;
            border-radius: 10px !important;
            padding: 0;
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        .otx-page .otx-estado-dropdown .dropdown-toggle::after{
            margin-left: .45rem;
            vertical-align: .15em;
        }

        .otx-page .otx-estado-dropdown .dropdown-menu{
            border-radius: 12px;
            border: 1px solid var(--otx-border);
            background: var(--otx-bg-card);
            box-shadow: 0 12px 30px rgba(0,0,0,.12);
            padding: 6px;
        }

        .otx-page .otx-estado-dropdown .dropdown-item{
            border-radius: 8px;
            color: var(--otx-text);
            font-size: .8rem;
            padding: 8px 10px;
            background: transparent;
        }

        .otx-page .otx-estado-dropdown .dropdown-item:hover{
            background: var(--otx-bg-head);
            color: var(--otx-text-strong);
        }

        .otx-page .otx-dot{
            width: 10px;
            height: 10px;
            border-radius: 999px;
            display: inline-block;
            flex: 0 0 auto;
        }

        .otx-page .otx-dot-pendiente{ background:#facc15; }
        .otx-page .otx-dot-inicio{ background:#38bdf8; }
        .otx-page .otx-dot-transito{ background:#3b82f6; }
        .otx-page .otx-dot-entregada{ background:#22c55e; }
        .otx-page .otx-dot-incidencia{ background:#ef4444; }

        .otx-page .otx-actions{
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .otx-page .otx-actions .btn{
            min-height: 28px;
            height: 28px;
            min-width: 28px;
            padding: 0 8px;
            border-radius: 8px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            box-shadow: none !important;
        }

        .otx-page .otx-actions .btn-default{
            background: var(--otx-input-bg) !important;
            color: var(--otx-text) !important;
            border: 1px solid var(--otx-input-border) !important;
        }

        .otx-page .otx-actions .btn-default:hover{
            background: var(--otx-bg-head) !important;
            color: var(--otx-text-strong) !important;
        }

        .otx-page .otx-empty{
            padding: 2rem 1rem;
            text-align: center;
            color: var(--otx-text-muted);
            font-size: .9rem;
        }

        .otx-page .card-footer{
            background: var(--otx-bg-card);
            border-top: 1px solid var(--otx-border);
            padding: 12px 16px;
        }

        .otx-page .pagination{
            margin-bottom: 0;
        }

        .otx-page .page-link{
            border-radius: 8px !important;
        }

        @media (max-width: 991.98px){
            .otx-page #ots-table{
                font-size: .8rem;
            }

            .otx-page #ots-table thead th,
            .otx-page #ots-table tbody td{
                padding: 8px 8px;
            }
        }
    </style>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="ots-table">
            <thead>
                <tr>
                    <th>OT</th>
                    <th>Cliente</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Vehículos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @forelse($ots as $ot)
                @php
                    $estadosDisponibles = [
                        'pendiente'      => ['label' => 'Pendiente',       'badge' => 'otx-badge-pendiente',  'dot' => 'otx-dot-pendiente'],
                        'inicio_carga'   => ['label' => 'Inicio de carga', 'badge' => 'otx-badge-inicio',     'dot' => 'otx-dot-inicio'],
                        'en_transito'    => ['label' => 'En tránsito',     'badge' => 'otx-badge-transito',   'dot' => 'otx-dot-transito'],
                        'entregada'      => ['label' => 'Entregada',       'badge' => 'otx-badge-entregada',  'dot' => 'otx-dot-entregada'],
                        'con_incidencia' => ['label' => 'Con incidencia',  'badge' => 'otx-badge-incidencia', 'dot' => 'otx-dot-incidencia'],
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
                    <td class="otx-col-id">
                        <div class="otx-id-main">
                            {{ $ot->folio ? $ot->folio : '#'.$ot->id }}
                        </div>
                        <span class="otx-id-sub">ID: {{ $ot->id }}</span>
                    </td>

                    <td class="otx-col-cliente">
                        <span class="otx-truncate" title="{{ $clienteNombre }}">{{ $clienteNombre }}</span>
                    </td>

                    <td class="otx-col-ubicacion">
                        <span class="otx-truncate" title="{{ $origen }}">{{ $origen }}</span>
                    </td>

                    <td class="otx-col-ubicacion">
                        <span class="otx-truncate" title="{{ $destino }}">{{ $destino }}</span>
                    </td>

                    <td class="otx-col-vehiculos">
                        @if($vehiculos->isEmpty())
                            <span class="text-muted">—</span>
                        @else
                            <span class="otx-chip otx-chip-count">
                                {{ $vehiculos->count() }} vehículo{{ $vehiculos->count() === 1 ? '' : 's' }}
                            </span>

                            <details class="otx-details">
                                <summary>Ver lista</summary>

                                <div class="otx-vehiculo-list">
                                    @foreach($vehiculos as $i => $v)
                                        <div class="otx-vehiculo-item">
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
                        @endif
                    </td>

                    <td class="otx-col-estado">
                        <div class="dropdown otx-estado-dropdown">
                            <button type="button"
                                    class="btn btn-default btn-xs dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                <span class="otx-badge {{ $cfg['badge'] }}">
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
                                                    class="dropdown-item d-flex align-items-center">
                                                <span class="otx-dot {{ $data['dot'] }} mr-2"></span>
                                                <span>{{ $data['label'] }}</span>
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </td>

                    <td class="otx-col-acciones">
                        {!! Form::open(['route' => ['ots.destroy', $ot->id], 'method' => 'delete']) !!}
                        <div class="otx-actions">
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
            @empty
                <tr>
                    <td colspan="7" class="otx-empty">
                        No hay OT para los filtros actuales.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $ots])
        </div>
    </div>
</div>