<div class="card-body p-0">
    <style>
        .cot-page #cotizacions-table{
            margin-bottom: 0;
            color: var(--cot-text);
            font-size: .84rem;
        }

        .cot-page #cotizacions-table thead th{
            background: var(--cot-bg-head);
            color: var(--cot-text-strong);
            border-bottom: 1px solid var(--cot-border) !important;
            border-top: 0 !important;
            font-size: .72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .03em;
            white-space: nowrap;
            padding: 10px 10px;
            vertical-align: middle;
        }

        .cot-page #cotizacions-table tbody td{
            border-color: var(--cot-border-soft) !important;
            padding: 8px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .cot-page #cotizacions-table tbody tr{
            transition: background-color .15s ease;
        }

        .cot-page #cotizacions-table tbody tr:nth-child(even){
            background: rgba(127, 127, 127, 0.03);
        }

        .cot-page #cotizacions-table tbody tr:hover{
            background: rgba(59, 130, 246, 0.08);
        }

        .cot-page .cot-col-id{
            min-width: 90px;
            max-width: 90px;
            font-weight: 800;
            color: var(--cot-text-strong);
        }

        .cot-page .cot-col-solicitud{
            min-width: 90px;
            max-width: 90px;
            color: var(--cot-text);
        }

        .cot-page .cot-col-cliente{
            min-width: 240px;
            max-width: 240px;
            font-weight: 700;
            color: var(--cot-text-strong);
        }

        .cot-page .cot-col-estado{
            min-width: 105px;
            max-width: 105px;
            text-align: center;
        }

        .cot-page .cot-col-monto{
            min-width: 130px;
            max-width: 130px;
            text-align: right;
            font-weight: 800;
            color: var(--cot-text-strong);
        }

        .cot-page .cot-col-fecha{
            min-width: 115px;
            max-width: 115px;
            color: var(--cot-text-muted);
            font-size: .78rem;
            line-height: 1.2;
        }

        .cot-page .cot-col-acciones{
            min-width: 150px;
            max-width: 150px;
        }

        .cot-page .cot-truncate{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .cot-page .cot-badge{
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

        .cot-page .cot-badge-enviada{
            background: #38bdf8;
            color: #082f49;
        }

        .cot-page .cot-badge-aceptada{
            background: #22c55e;
            color: #ffffff;
        }

        .cot-page .cot-badge-rechazada{
            background: #ef4444;
            color: #ffffff;
        }

        .cot-page .cot-badge-default{
            background: var(--cot-bg-head);
            color: var(--cot-text);
            border-color: var(--cot-border);
        }

        .cot-page .cot-actions{
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .cot-page .cot-actions .btn{
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

        .cot-page .cot-actions .btn-default{
            background: var(--cot-input-bg) !important;
            color: var(--cot-text) !important;
            border: 1px solid var(--cot-input-border) !important;
        }

        .cot-page .cot-actions .btn-default:hover{
            background: var(--cot-bg-head) !important;
            color: var(--cot-text-strong) !important;
        }

        .cot-page .cot-actions .btn.disabled,
        .cot-page .cot-actions .btn:disabled{
            opacity: .55 !important;
            pointer-events: auto !important;
            cursor: not-allowed !important;
        }

        .cot-page .cot-empty{
            padding: 2rem 1rem;
            text-align: center;
            color: var(--cot-text-muted);
            font-size: .9rem;
        }

        .cot-page .card-footer{
            background: var(--cot-bg-card);
            border-top: 1px solid var(--cot-border);
            padding: 12px 16px;
        }

        .cot-page .pagination{
            margin-bottom: 0;
        }

        .cot-page .page-link{
            border-radius: 8px !important;
        }

        @media (max-width: 991.98px){
            .cot-page #cotizacions-table{
                font-size: .8rem;
            }

            .cot-page #cotizacions-table thead th,
            .cot-page #cotizacions-table tbody td{
                padding: 8px 8px;
            }
        }
    </style>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="cotizacions-table">
            <thead>
                <tr>
                    <th>Cotización</th>
                    <th>Solicitud</th>
                    <th>Cliente</th>
                    <th class="text-center">Estado</th>
                    <th class="text-right">Monto</th>
                    <th>Creado</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cotizacions as $cotizacion)
                    <tr>
                        <td class="cot-col-id">
                            #{{ $cotizacion->id }}
                        </td>

                        <td class="cot-col-solicitud">
                            @if($cotizacion->solicitud)
                                #{{ $cotizacion->solicitud->id }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="cot-col-cliente">
                            <span class="cot-truncate" title="{{ optional(optional($cotizacion->solicitud)->cliente)->razon_social ?? '-' }}">
                                {{ optional(optional($cotizacion->solicitud)->cliente)->razon_social ?? '-' }}
                            </span>
                        </td>

                        <td class="cot-col-estado">
                            @if($cotizacion->estado === 'enviada')
                                <span class="cot-badge cot-badge-enviada">Enviada</span>
                            @elseif($cotizacion->estado === 'aceptada')
                                <span class="cot-badge cot-badge-aceptada">Aceptada</span>
                            @elseif($cotizacion->estado === 'rechazada')
                                <span class="cot-badge cot-badge-rechazada">Rechazada</span>
                            @else
                                <span class="cot-badge cot-badge-default">
                                    {{ $cotizacion->estado ?? 'N/A' }}
                                </span>
                            @endif
                        </td>

                        <td class="cot-col-monto">
                            @if(!is_null($cotizacion->monto))
                                {{ number_format($cotizacion->monto, 0, ',', '.') }} CLP
                            @else
                                -
                            @endif
                        </td>

                        <td class="cot-col-fecha">
                            @if($cotizacion->created_at)
                                {{ $cotizacion->created_at->format('d/m/y') }}<br>
                                <span class="text-muted">{{ $cotizacion->created_at->format('H:i') }}</span>
                            @endif
                        </td>

                        <td class="cot-col-fecha">
                            @if($cotizacion->updated_at)
                                {{ $cotizacion->updated_at->format('d/m/y') }}<br>
                                <span class="text-muted">{{ $cotizacion->updated_at->format('H:i') }}</span>
                            @endif
                        </td>

                        <td class="cot-col-acciones">
                            <form id="generar-ot-{{ $cotizacion->id }}"
                                  action="{{ route('cotizacions.generarOt', $cotizacion->id) }}"
                                  method="POST"
                                  style="display:none;">
                                @csrf
                            </form>

                            <form id="eliminar-cot-{{ $cotizacion->id }}"
                                  action="{{ route('cotizacions.destroy', $cotizacion->id) }}"
                                  method="POST"
                                  style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <div class="cot-actions">
                                @if($cotizacion->ot)
                                    <a href="{{ route('ots.show', $cotizacion->ot->id) }}"
                                       class="btn btn-success btn-xs"
                                       title="Ver OT">
                                        <i class="fas fa-file-alt"></i>
                                    </a>

                                @elseif($cotizacion->estado === 'aceptada')
                                    <a href="#"
                                       class="btn btn-success btn-xs disabled"
                                       title="OT aún no generada"
                                       onclick="event.preventDefault(); alert('Esta cotización está aceptada, pero todavía no tiene OT asociada.');">
                                        <i class="fas fa-file-alt"></i>
                                    </a>

                                @else
                                    <a href="#"
                                       class="btn btn-success btn-xs"
                                       title="Generar OT"
                                       onclick="event.preventDefault();
                                           if (confirm('¿Generar una OT desde esta cotización?')) {
                                               document.getElementById('generar-ot-{{ $cotizacion->id }}').submit();
                                           }">
                                        <i class="fas fa-truck"></i>
                                    </a>
                                @endif

                                <a href="{{ route('cotizacions.show', $cotizacion->id) }}"
                                   class="btn btn-default btn-xs"
                                   title="Ver">
                                    <i class="far fa-eye"></i>
                                </a>

                                <a href="{{ route('cotizacions.edit', $cotizacion->id) }}"
                                   class="btn btn-default btn-xs"
                                   title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>

                                <a href="#"
                                   class="btn btn-danger btn-xs"
                                   title="Eliminar"
                                   onclick="event.preventDefault();
                                       if (confirm('¿Eliminar esta cotización?')) {
                                           document.getElementById('eliminar-cot-{{ $cotizacion->id }}').submit();
                                       }">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="cot-empty">
                            No hay cotizaciones para los filtros actuales.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $cotizacions])
        </div>
    </div>
</div>