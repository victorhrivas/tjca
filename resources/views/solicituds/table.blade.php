<div class="card-body p-0">
    <style>
        .sol-page #solicituds-table{
            margin-bottom: 0;
            color: var(--sol-text);
            font-size: .84rem;
        }

        .sol-page #solicituds-table thead th{
            background: var(--sol-bg-head);
            color: var(--sol-text-strong);
            border-bottom: 1px solid var(--sol-border) !important;
            border-top: 0 !important;
            font-size: .72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .03em;
            white-space: nowrap;
            padding: 10px 10px;
            vertical-align: middle;
        }

        .sol-page #solicituds-table tbody td{
            border-color: var(--sol-border-soft) !important;
            padding: 8px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .sol-page #solicituds-table tbody tr{
            transition: background-color .15s ease;
        }

        .sol-page #solicituds-table tbody tr:nth-child(even){
            background: rgba(127, 127, 127, 0.03);
        }

        .sol-page #solicituds-table tbody tr:hover{
            background: rgba(59, 130, 246, 0.08);
        }

        .sol-page .sol-col-cliente{
            min-width: 240px;
            max-width: 240px;
            font-weight: 700;
            color: var(--sol-text-strong);
        }

        .sol-page .sol-col-canal{
            min-width: 95px;
            max-width: 95px;
        }

        .sol-page .sol-col-ubicacion{
            min-width: 150px;
            max-width: 150px;
        }

        .sol-page .sol-col-carga{
            min-width: 170px;
            max-width: 170px;
        }

        .sol-page .sol-col-valor{
            min-width: 110px;
            max-width: 110px;
            text-align: right;
            font-weight: 800;
            color: var(--sol-text-strong);
        }

        .sol-page .sol-col-creada{
            min-width: 110px;
            max-width: 110px;
            color: var(--sol-text-muted);
            font-size: .78rem;
            line-height: 1.2;
        }

        .sol-page .sol-col-estado{
            min-width: 105px;
            max-width: 105px;
            text-align: center;
        }

        .sol-page .sol-col-acciones{
            min-width: 170px;
            max-width: 170px;
        }

        .sol-page .sol-truncate{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .sol-page .sol-badge{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 800;
            line-height: 1;
            border: 1px solid transparent;
            min-width: 86px;
        }

        .sol-page .sol-badge-pendiente{
            background: #facc15;
            color: #3b2f00;
        }

        .sol-page .sol-badge-aprobada{
            background: #22c55e;
            color: #ffffff;
        }

        .sol-page .sol-badge-fallida{
            background: #ef4444;
            color: #ffffff;
        }

        .sol-page .sol-actions{
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .sol-page .sol-actions .btn{
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

        .sol-page .sol-actions .btn-default{
            background: var(--sol-input-bg) !important;
            color: var(--sol-text) !important;
            border: 1px solid var(--sol-input-border) !important;
        }

        .sol-page .sol-actions .btn-default:hover{
            background: var(--sol-bg-head) !important;
            color: var(--sol-text-strong) !important;
        }

        .sol-page .sol-empty{
            padding: 2rem 1rem;
            text-align: center;
            color: var(--sol-text-muted);
            font-size: .9rem;
        }

        .sol-page .card-footer{
            background: var(--sol-bg-card);
            border-top: 1px solid var(--sol-border);
            padding: 12px 16px;
        }

        .sol-page .pagination{
            margin-bottom: 0;
        }

        .sol-page .page-link{
            border-radius: 8px !important;
        }

        @media (max-width: 991.98px){
            .sol-page #solicituds-table{
                font-size: .8rem;
            }

            .sol-page #solicituds-table thead th,
            .sol-page #solicituds-table tbody td{
                padding: 8px 8px;
            }
        }
    </style>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="solicituds-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Canal</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Carga</th>
                    <th class="text-right">Valor</th>
                    <th>Creada</th>
                    <th class="text-center">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($solicituds as $solicitud)
                    <tr>
                        <td class="sol-col-cliente">
                            <span class="sol-truncate" title="{{ optional($solicitud->cliente)->razon_social ?? 'Sin cliente' }}">
                                {{ optional($solicitud->cliente)->razon_social ?? 'Sin cliente' }}
                            </span>
                        </td>

                        <td class="sol-col-canal">
                            <span class="sol-truncate" title="{{ $solicitud->canal }}">
                                {{ $solicitud->canal ?? '—' }}
                            </span>
                        </td>

                        <td class="sol-col-ubicacion">
                            <span class="sol-truncate" title="{{ $solicitud->origen }}">
                                {{ $solicitud->origen ?? '—' }}
                            </span>
                        </td>

                        <td class="sol-col-ubicacion">
                            <span class="sol-truncate" title="{{ $solicitud->destino }}">
                                {{ $solicitud->destino ?? '—' }}
                            </span>
                        </td>

                        <td class="sol-col-carga">
                            <span class="sol-truncate" title="{{ $solicitud->carga }}">
                                {{ $solicitud->carga ?? '—' }}
                            </span>
                        </td>

                        <td class="sol-col-valor">
                            @if(!is_null($solicitud->valor))
                                $ {{ number_format($solicitud->valor, 0, ',', '.') }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="sol-col-creada">
                            @if($solicitud->created_at)
                                {{ $solicitud->created_at->format('d/m/y') }}<br>
                                <span class="text-muted">{{ $solicitud->created_at->format('H:i') }}</span>
                            @endif
                        </td>

                        <td class="sol-col-estado">
                            @if($solicitud->estado === 'pendiente')
                                <span class="sol-badge sol-badge-pendiente">Pendiente</span>
                            @elseif($solicitud->estado === 'aprobada')
                                <span class="sol-badge sol-badge-aprobada">Aprobada</span>
                            @elseif($solicitud->estado === 'fallida')
                                <span class="sol-badge sol-badge-fallida">Fallida</span>
                            @else
                                <span class="sol-badge" style="background: var(--sol-bg-head); color: var(--sol-text); border-color: var(--sol-border);">—</span>
                            @endif
                        </td>

                        <td class="sol-col-acciones">
                            <form id="aprobar-{{ $solicitud->id }}"
                                  action="{{ route('solicituds.aprobar', $solicitud->id) }}"
                                  method="POST"
                                  style="display:none;">
                                @csrf
                            </form>

                            <form id="eliminar-{{ $solicitud->id }}"
                                  action="{{ route('solicituds.destroy', $solicitud->id) }}"
                                  method="POST"
                                  style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            @if($solicitud->estado !== 'aprobada')
                                <form id="fallida-{{ $solicitud->id }}"
                                      action="{{ route('solicituds.fallida', $solicitud->id) }}"
                                      method="POST"
                                      style="display:none;">
                                    @csrf
                                </form>
                            @endif

                            <div class="sol-actions">
                                @if(!$solicitud->cotizacion)
                                    <a href="#"
                                       class="btn btn-success btn-xs"
                                       title="Aprobar"
                                       onclick="event.preventDefault();
                                           if (confirm('¿Aprobar la solicitud y generar una cotización?')) {
                                               document.getElementById('aprobar-{{ $solicitud->id }}').submit();
                                           }">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @else
                                    <a href="{{ route('cotizacions.show', $solicitud->cotizacion->id) }}"
                                       class="btn btn-success btn-xs"
                                       title="Ver cotización">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </a>
                                @endif

                                @if($solicitud->estado !== 'aprobada')
                                    <a href="#"
                                       class="btn btn-warning btn-xs"
                                       title="Marcar como fallida"
                                       onclick="event.preventDefault();
                                           if (confirm('¿Marcar esta solicitud como fallida?')) {
                                               document.getElementById('fallida-{{ $solicitud->id }}').submit();
                                           }">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif

                                <a href="{{ route('solicituds.show', $solicitud->id) }}"
                                   class="btn btn-default btn-xs"
                                   title="Ver">
                                    <i class="far fa-eye"></i>
                                </a>

                                <a href="{{ route('solicituds.edit', $solicitud->id) }}"
                                   class="btn btn-default btn-xs"
                                   title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>

                                <a href="#"
                                   class="btn btn-danger btn-xs"
                                   title="Eliminar"
                                   onclick="event.preventDefault();
                                       if (confirm('¿Eliminar esta solicitud?')) {
                                           document.getElementById('eliminar-{{ $solicitud->id }}').submit();
                                       }">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="sol-empty">
                            No hay solicitudes para los filtros actuales.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $solicituds])
        </div>
    </div>
</div>